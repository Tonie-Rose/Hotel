<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You must be logged in to reserve a room.']);
    exit();
}

$user_id = $_SESSION['user_id'];
$room_id = $_POST['room_id'] ?? null;
$check_in = $_POST['check_in'] ?? null;
$check_out = $_POST['check_out'] ?? null;

if (empty($room_id) || empty($check_in) || empty($check_out)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit();
}

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $check_in) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $check_out)) {
    echo json_encode(['success' => false, 'message' => 'Invalid date format.']);
    exit();
}

try {
    // Check room availability
    $stmt = $pdo->prepare("SELECT * FROM reservations 
        WHERE room_id = ? 
        AND status = 'reserved' 
        AND (
            (check_in <= ? AND check_out > ?) OR 
            (check_in < ? AND check_out >= ?) OR 
            (check_in >= ? AND check_out <= ?)
        )");
    $stmt->execute([$room_id, $check_in, $check_in, $check_out, $check_out, $check_in, $check_out]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Room is already reserved for the selected dates.']);
        exit();
    }

    // Insert reservation
    $insert = $pdo->prepare("INSERT INTO reservations (user_id, room_id, check_in, check_out, status) VALUES (?, ?, ?, ?, 'reserved')");
    $inserted = $insert->execute([$user_id, $room_id, $check_in, $check_out]);

    if (!$inserted) {
        echo json_encode(['success' => false, 'message' => 'Failed to reserve room. Please try again.']);
        exit();
    }

    // Get last inserted reservation ID
    $reservation_id = $pdo->lastInsertId();

    // Optionally update room status here if you want
    // $updateRoom = $pdo->prepare("UPDATE rooms SET status = 'reserved' WHERE room_id = ?");
    // $updateRoom->execute([$room_id]);

    echo json_encode(['success' => true, 'message' => 'Room reserved successfully!', 'reservation_id' => $reservation_id]);
    exit();

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    exit();
}

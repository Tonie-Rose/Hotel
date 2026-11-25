<?php
require_once '../db.php';

$response = ['success' => false, 'message' => 'Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $room_number = trim($_POST['room_number'] ?? '');
  $room_type = trim($_POST['room_type'] ?? '');
  $bed_type = trim($_POST['bed_type'] ?? '');
  $capacity = intval($_POST['capacity'] ?? 0);
  $floor = intval($_POST['floor'] ?? 0);
  $price = floatval($_POST['price'] ?? 0);
  $status = trim($_POST['status'] ?? '');
  $description = trim($_POST['description'] ?? '');

  // Basic validation
  if ($room_number === '' || $room_type === '' || $bed_type === '' || $capacity <= 0 || $price < 0 || $status === '') {
    $response['message'] = 'Please fill all required fields correctly.';
  } else {
    try {
      $stmt = $pdo->prepare("INSERT INTO rooms (room_number, room_type, bed_type, capacity, floor, price, status, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->execute([$room_number, $room_type, $bed_type, $capacity, $floor, $price, $status, $description]);
      $response['success'] = true;
      $response['message'] = 'Room added successfully.';
    } catch (PDOException $e) {
      $response['message'] = 'Database error: ' . $e->getMessage();
    }
  }
}

header('Content-Type: application/json');
echo json_encode($response);

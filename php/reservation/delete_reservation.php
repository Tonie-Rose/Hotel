<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['reservation_id'];

    try {
        $stmt = $pdo->prepare("UPDATE reservations SET status = 'cancelled' WHERE reservation_id = ?");
        $stmt->execute([$id]);

        echo json_encode(['success' => true, 'message' => 'Reservation cancelled.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Cancellation failed.']);
    }
}

<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['reservation_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE reservations SET check_in = ?, check_out = ?, status = ? WHERE reservation_id = ?");
        $stmt->execute([$check_in, $check_out, $status, $id]);

        echo json_encode(['success' => true, 'message' => 'Reservation updated.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Update failed.']);
    }
}

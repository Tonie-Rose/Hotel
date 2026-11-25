<?php
session_start();
require 'php/db.php';

if (!isset($_POST['reservation_id'], $_POST['amount'])) {
    echo "Invalid request.";
    exit();
}

$reservation_id = $_POST['reservation_id'];
$amount = $_POST['amount'];

// Insert payment
try {
    $stmt = $pdo->prepare("INSERT INTO payments (reservation_id, payment_date, amount_paid, payment_status) VALUES (?, NOW(), ?, 'paid')");
    $stmt->execute([$reservation_id, $amount]);

    // Update reservation status
    $stmt = $pdo->prepare("UPDATE reservations SET status = 'paid' WHERE reservation_id = ?");
    $stmt->execute([$reservation_id]);

    echo "<script>alert('Payment successful!'); window.location.href='../view_reservation.php';</script>";
} catch (Exception $e) {
    echo "Payment failed: " . $e->getMessage();
}
?>

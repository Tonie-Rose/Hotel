<?php
require_once '../db.php'; // Adjust path based on location

if (!isset($_POST['payment_id'])) {
    echo "Invalid request.";
    exit;
}

$payment_id = $_POST['payment_id'];

// Step 1: Get reservation_id from payments
$stmt = $pdo->prepare("SELECT reservation_id FROM payments WHERE payment_id = ?");
$stmt->execute([$payment_id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    echo "Payment not found.";
    exit;
}

$reservation_id = $reservation['reservation_id'];

// Step 2: Update payment status
$updatePayment = $pdo->prepare("UPDATE payments SET payment_status = 'Refunded' WHERE payment_id = ? AND payment_status != 'Refunded'");
$updatePayment->execute([$payment_id]);

if ($updatePayment->rowCount() > 0) {
    // Optional: Update reservation status to Cancelled
    $cancelRes = $pdo->prepare("UPDATE reservations SET status = 'Cancelled' WHERE reservation_id = ?");
    $cancelRes->execute([$reservation_id]);

    echo "Payment refunded successfully.";
} else {
    echo "Payment not found or already refunded.";
}

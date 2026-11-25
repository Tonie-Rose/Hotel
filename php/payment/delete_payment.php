<?php
require_once '../db.php';

if (!isset($_POST['payment_id'])) {
    echo "Invalid request.";
    exit;
}

$payment_id = $_POST['payment_id'];

// Delete payment record
$sql = "DELETE FROM payments WHERE payment_id = ?";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$payment_id]) && $stmt->rowCount() > 0) {
    echo "Payment deleted successfully.";
} else {
    echo "Payment not found or could not be deleted.";
}

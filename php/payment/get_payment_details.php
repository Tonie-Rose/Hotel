<?php
require_once '../db.php';  // Adjust path if needed

if (!isset($_POST['payment_id'])) {
    echo '<p>Invalid request: payment_id missing.</p>';
    exit;
}

$payment_id = $_POST['payment_id'];

// Fetch payment + user + reservation + room info
$stmt = $pdo->prepare("
    SELECT p.payment_id, p.amount_paid, p.payment_date, p.payment_status, 
           u.full_name, u.email,
           r.check_in, r.check_out, r.status AS reservation_status,
           rm.room_number, rm.room_type
    FROM payments p
    JOIN reservations r ON p.reservation_id = r.reservation_id
    JOIN users u ON r.user_id = u.user_id
    JOIN rooms rm ON r.room_id = rm.room_id
    WHERE p.payment_id = ?
");
$stmt->execute([$payment_id]);
$payment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$payment) {
    echo '<p>Payment not found.</p>';
    exit;
}
?>

<table style="width:100%; border-collapse: collapse;">
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">User Name:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($payment['full_name']) ?></td></tr>
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">Email:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($payment['email']) ?></td></tr>
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">Amount Paid:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;">$<?= number_format($payment['amount_paid'], 2) ?></td></tr>
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">Payment Date:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars(date('Y-m-d', strtotime($payment['payment_date']))) ?></td></tr>
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">Payment Status:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($payment['payment_status']) ?></td></tr>
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">Check In:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($payment['check_in']) ?></td></tr>
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">Check Out:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($payment['check_out']) ?></td></tr>
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">Room Number:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($payment['room_number']) ?></td></tr>
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">Room Type:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($payment['room_type']) ?></td></tr>
  <tr><th style="text-align:left; padding: 8px; border-bottom: 1px solid #ddd;">Reservation Status:</th><td style="padding: 8px; border-bottom: 1px solid #ddd;"><?= htmlspecialchars($payment['reservation_status']) ?></td></tr>
</table>

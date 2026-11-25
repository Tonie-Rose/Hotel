<?php
session_start();
require 'php/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$reservation_id = $_GET['reservation_id'] ?? null;

if (!$reservation_id) {
    die('Reservation ID is required.');
}
$stmt = $pdo->prepare("SELECT r.*, rm.price, rm.room_number FROM reservations r
    JOIN rooms rm ON r.room_id = rm.room_id
    WHERE r.reservation_id = ? AND r.user_id = ?");
$stmt->execute([$reservation_id, $user_id]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$reservation) {
    die('Reservation not found or you do not have permission.');
}
$checkIn = new DateTime($reservation['check_in']);
$checkOut = new DateTime($reservation['check_out']);
$interval = $checkIn->diff($checkOut);
$nights = $interval->days;
$totalPrice = $nights * $reservation['price'];
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount_paid = $_POST['amount_paid'] ?? 0;
    $payment_method = $_POST['payment_method'] ?? 'N/A';

    if ($amount_paid < $totalPrice) {
        $message = "Amount paid must be at least ₱" . number_format($totalPrice, 2);
    } else {

        $insert = $pdo->prepare("INSERT INTO payments (reservation_id, payment_date, amount_paid, payment_status, payment_method) VALUES (?, NOW(), ?, 'paid', ?)");
        $inserted = $insert->execute([$reservation_id, $amount_paid, $payment_method]);

        if ($inserted) {
            $update = $pdo->prepare("UPDATE reservations SET status = 'paid' WHERE reservation_id = ?");
            $update->execute([$reservation_id]);

            $message = "Payment successful! Thank you.";
        } else {
            $message = "Payment failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="css/payment.css" />
<title>Payment - Paradise Hotel</title>
</head>
<body>
<div class="container">
    <h1>Payment for Reservation #<?= htmlspecialchars($reservation_id) ?></h1>
    <ul class="info-list">
        <li><strong>Room Number:</strong> <?= htmlspecialchars($reservation['room_number']) ?></li>
        <li><strong>Check-in:</strong> <?= htmlspecialchars($reservation['check_in']) ?></li>
        <li><strong>Check-out:</strong> <?= htmlspecialchars($reservation['check_out']) ?></li>
        <li><strong>Nights:</strong> <?= $nights ?></li>
        <li><strong>Total Price:</strong> ₱<?= number_format($totalPrice, 2) ?></li>
    </ul>
    <?php if ($message): ?>
        <p class="message <?= strpos($message, 'successful') !== false ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </p>
    <?php endif; ?>
    <?php if (empty($message) || strpos($message, 'failed') !== false): ?>
    <form method="POST" novalidate>
        <label for="amount_paid">Amount Paid (₱)</label>
        <input type="number" step="0.01" min="<?= $totalPrice ?>" name="amount_paid" id="amount_paid" required />

        <label for="payment_method">Payment Method</label>
        <select name="payment_method" id="payment_method" required>
            <option value="GCash">GCash</option>
            <option value="PayPal">PayPal</option>
        </select>
        <button type="submit">Pay Now</button>
    </form>
    <?php else: ?>
        <a href="userdashboard.php" class="back-link">Go back to Dashboard</a>
    <?php endif; ?>
</div>
</body>
</html>

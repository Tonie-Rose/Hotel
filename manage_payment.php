<?php
require_once 'php/db.php';

$sql = "SELECT 
          p.payment_id,
          p.payment_date,
          p.amount_paid,
          p.payment_status,
          u.full_name,
          u.email
        FROM payments p
        JOIN reservations r ON p.reservation_id = r.reservation_id
        JOIN users u ON r.user_id = u.user_id
        ORDER BY p.payment_date DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="css/manage_payment.css" />
<title>Manage Payments - Paradise Hotel</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous"
  />
</head>
<body>
  <header>
    <div class="logo">
      <h2>Paradise Hotel - Admin Dashboard</h2>
    </div>
    <nav>
      <a href="admin-dashboard.php" class="active"><i class="fas fa-home"></i>Home</a>
      <a href="manage_rooms.php"><i class="fas fa-bed"></i>Manage Rooms</a>
      <a href="manage_users.php"><i class="fas fa-users"></i>Manage Users</a>
      <a href="manage_reservation.php"><i class="fas fa-calendar-check"></i>Manage Reservation</a>
      <a href="manage_payment.php"><i class="fas fa-credit-card"></i>Manage Payment</a>
      <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
    </nav>
  </header>
<section class="dashboard-content">
  <h2>Payments Overview</h2>
  <p>Overview of all payments made by users.</p>
  <table class="styled-table">
    <thead>
      <tr>
        <th>User Name</th>
        <th>Amount Paid</th>
        <th>Payment Date</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($payments) === 0): ?>
        <tr><td colspan="5" style="text-align:center;">No payments found.</td></tr>
      <?php else: ?>
        <?php foreach ($payments as $pay): ?>
          <tr>
            <td><?= htmlspecialchars($pay['full_name']) ?></td>
            <td>$<?= number_format($pay['amount_paid'], 2) ?></td>
            <td><?= htmlspecialchars(date('Y-m-d', strtotime($pay['payment_date']))) ?></td>
            <td><?= htmlspecialchars($pay['payment_status']) ?></td>
            <td>
        <button class="btn view-btn" data-id="<?= $pay['payment_id'] ?>" data-tooltip="View Payment Details">View</button>
        <button class="btn refund-btn" data-id="<?= $pay['payment_id'] ?>" data-tooltip="Refund Payment">Refund</button>
        <button class="btn delete-btn" data-id="<?= $pay['payment_id'] ?>" data-tooltip="Delete Payment">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</section>
<div id="viewModal" class="modal">
  <div class="modal-content">
    <span class="close-btn">&times;</span>
    <h3>Payment Details</h3>
    <div id="paymentDetails">
    </div>
  </div>
</div>
<script src="jquery/jquery.min.js"></script>
<script src="jquery/admin/manage_payment.js"></script>
</body>
</html>

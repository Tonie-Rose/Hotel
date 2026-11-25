<?php
session_start();
require 'php/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
$stmtUser = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
$stmtUser->execute([$_SESSION['user_id']]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header("Location: index.php");
    exit();
}
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE status = 'available'");
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Available Rooms - Paradise Hotel</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      background-image: url("image/bg8.jpg");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      color: #333;
    }

    header {
      background: rgba(0, 0, 0, 0.8);
      color: gold;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.5);
    }

    .logo h2 {
      font-family: 'Playfair Display', serif;
      font-size: 1.8rem;
    }

    nav a {
      color: gold;
      margin-left: 20px;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }

    nav a:hover, nav a.active {
      color: #fff3cd;
    }

    main {
      padding: 2rem;
      text-align: center;
      background: rgba(237, 231, 231, 0.39);
      margin: 2rem auto;
      width: 90%;
      max-width: 1100px;
      border-radius: 16px;
      box-shadow: 0 8px 30px rgba(255, 255, 255, 0.34);
    }

    main h1 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      margin-bottom: 2rem;
      color: #222;
    }

    .rooms-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 1.5rem;
      padding: 1rem;
    }

    .room-card {
      background: #fff;
      border-left: 5px solid gold;
      border-radius: 12px;
      padding: 1.2rem;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .room-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
    }

    .room-info p {
      margin: 0.4rem 0;
      font-size: 1rem;
    }

    .room-info span {
      font-weight: bold;
    }

    .reserve-btn {
      margin-top: 1rem;
      padding: 0.6rem 1.2rem;
      background-color: gold;
      color: #000;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .reserve-btn:hover {
      background-color: #e0b800;
    }

    .modal {
    display: none; /* <-- Fix this */
    position: fixed;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
    justify-content: center;
    align-items: center;
    z-index: 1000;
    }

    .modal-content {
      background: white;
      padding: 2rem;
      border-radius: 12px;
      width: 90%;
      max-width: 400px;
      position: relative;
    }
    .modal-content h3 {
      margin-bottom: 1rem;
      font-family: 'Playfair Display', serif;
      color: #333;
    }

    .close-btn {
      position: absolute;
      top: 1rem;
      right: 1rem;
      font-size: 1.5rem;
      cursor: pointer;
      color: #666;
    }

    label {
      display: block;
      margin-top: 1rem;
      text-align: left;
    }

    input[type="date"] {
      width: 100%;
      padding: 0.5rem;
      margin-top: 0.3rem;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .submit-btn {
      margin-top: 1.5rem;
      padding: 0.6rem 1.2rem;
      background-color: gold;
      color: #000;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
    }

    footer {
      background: #1c1c1c;
      color: #ccc;
      text-align: center;
      padding: 1rem;
      margin-top: 3rem;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <header>
    <div class="logo">
      <h2>Paradise Hotel</h2>
    </div>
        <nav>
        <a href="userdashboard.php" class="active"><i class="fas fa-home"></i> Home</a>
        <a href="view_rooms.php"><i class="fas fa-bed"></i> Available Rooms</a>
        <a href="view_reservation.php"><i class="fas fa-calendar-check"></i> My Reservations</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </nav>
  </header>

<main>
  <h1>Welcome, <?= htmlspecialchars($user['full_name']); ?>!</h1>
  <div class="rooms-container">
    <?php if (count($rooms) === 0): ?>
      <p>No available rooms at the moment.</p>
    <?php else: ?>
      <?php foreach ($rooms as $room): ?>
        <div class="room-card" data-room-id="<?= (int)$room['room_id'] ?>" data-room-number="<?= htmlspecialchars($room['room_number']) ?>">
          <div class="room-info">
            <p><span>Room #:</span> <?= htmlspecialchars($room['room_number']) ?></p>
            <p><span>Type:</span> <?= htmlspecialchars($room['room_type']) ?></p>
            <p><span>Bed:</span> <?= htmlspecialchars($room['bed_type']) ?></p>
            <p><span>Capacity:</span> <?= htmlspecialchars($room['capacity']) ?> pax</p>
            <p><span>Floor:</span> <?= htmlspecialchars($room['floor']) ?></p>
            <p><span>Price:</span> ₱<?= number_format($room['price'], 2) ?></p>
            <p><span>Note:</span> <?= htmlspecialchars($room['description']) ?></p>
          </div>
          <button class="reserve-btn">Reserve</button>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</main>

<footer>
  &copy; <?= date('Y') ?> Paradise Hotel. All rights reserved.
</footer>
<div id="reservationModal" class="modal" aria-hidden="true" role="dialog">
  <div class="modal-content">
    <span class="close-btn" role="button" aria-label="Close modal">&times;</span>
    <h3 id="modalTitle">Reserve Room <span id="modalRoomNumber"></span></h3>
    <form id="reservationForm" novalidate>
      <input type="hidden" name="room_id" id="modalRoomId" />
      <label for="checkin">Check-in Date</label>
      <input type="date" id="checkin" name="check_in" required min="<?= date('Y-m-d'); ?>" />
      <label for="checkout">Check-out Date</label>
      <input type="date" id="checkout" name="check_out" required min="<?= date('Y-m-d', strtotime('+1 day')); ?>" />
      <button type="submit" class="submit-btn">Confirm Reservation</button>
    </form>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="jquery/view_rooms.js"></script>
</body>
</html>

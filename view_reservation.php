<?php
session_start();
require 'php/db.php';

// Redirect if not logged in
if (empty($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info safely
$stmtUser = $pdo->prepare("SELECT full_name FROM users WHERE user_id = ?");
$stmtUser->execute([$user_id]);
$user = $stmtUser->fetch(PDO::FETCH_ASSOC);

// If user not found (possible session issue), log out
if (!$user) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Fetch reservations with joined data
$sql = "
    SELECT r.*, rm.room_number, rm.room_type, 
           COALESCE(p.amount_paid, 0) AS amount_paid,
           p.payment_status,
           p.payment_date
    FROM reservations r 
    JOIN rooms rm ON r.room_id = rm.room_id 
    LEFT JOIN payments p ON r.reservation_id = p.reservation_id 
    WHERE r.user_id = ?
    ORDER BY r.check_in DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Helper function to safely output data
function e($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Helper function to format date nicely
function formatDate($dateStr) {
    return date("F j, Y", strtotime($dateStr));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>My Reservations - Paradise Hotel</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
  /* Reset & Base */
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Open Sans', sans-serif;
    background: url("image/bg6.jpg") no-repeat center center fixed;
    background-size: cover;
    color: #333;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  header {
    background: rgba(0, 0, 0, 0.85);
    color: gold;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.6);
  }
  .logo h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
  }
  nav a {
    color: gold;
    margin-left: 20px;
    text-decoration: none;
    font-weight: 700;
    letter-spacing: 0.03em;
    transition: color 0.3s ease;
  }
  nav a:hover, nav a.active {
    color: #fff3cd;
  }
  main {
    flex-grow: 1;
    max-width: 1000px;
    margin: 2.5rem auto 3rem;
    padding: 0 20px;
    background: rgba(219, 211, 120, 0.28);
    border-radius: 12px;
    box-shadow: 0 4px 14px rgba(209, 202, 202, 0.15);
  }
  h1 {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 2.4rem;
    color:rgb(37, 39, 40);
    margin-bottom: 1.8rem;
    text-align: center;
  }
  .card-container {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(320px,1fr));
    gap: 22px;
  }
  .card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 3px 12px rgba(212, 207, 207, 0.06);
    padding: 20px;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 6px 24px rgba(0,0,0,0.15);
  }
  .card p {
    margin: 8px 0;
    font-size: 15px;
    color: #444;
  }
  .status-badge {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 15px;
    font-size: 13px;
    font-weight: 700;
    color: #fff;
    text-transform: capitalize;
    user-select: none;
  }
  .reserved { background-color: #3498db; }
  .checkedin { background-color: #2ecc71; }
  .cancelled { background-color: #e74c3c; }
  .paid { background-color: #27ae60; }
  .unpaid { background-color: #c0392b; }
  .pending { background-color: #f39c12; }

  .cancel-btn {
    margin-top: 12px;
    background-color: #e74c3c;
    color: white;
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 700;
    font-size: 15px;
    transition: background-color 0.25s ease;
    align-self: flex-start;
  }
  .cancel-btn:hover {
    background-color: #c0392b;
  }
  @media (max-width: 600px) {
    nav {
      display: flex;
      flex-wrap: wrap;
      margin-top: 10px;
      justify-content: center;
    }
    nav a {
      margin: 5px 10px 0 0;
    }
    main {
      margin: 1.5rem 10px 2rem;
      padding: 15px;
    }
    .card-container {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>
<header>
  <div class="logo"><h2>Paradise Hotel</h2></div>
  <nav>
    <a href="userdashboard.php" class="active" aria-current="page"><i class="fas fa-home"></i> Home</a>
    <a href="view_rooms.php"><i class="fas fa-bed"></i> Available Rooms</a>
    <a href="view_reservation.php"><i class="fas fa-calendar-check"></i> My Reservations</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </nav>
</header>
<main>
  <h1>Your trip, your way. View your bookings below.</h1>
  <?php if (empty($reservations)): ?>
    <p style="text-align:center; font-size: 1.15rem; color: #555;">You have no reservations yet.</p>
  <?php else: ?>
    <div class="card-container" role="list" aria-label="User Reservations">
      <?php foreach ($reservations as $res): ?>
        <?php
          $resStatusClass = strtolower(str_replace(' ', '', $res['status']));
          $payStatusClass = $res['payment_status'] ? strtolower(str_replace(' ', '', $res['payment_status'])) : 'pending';

          $checkIn = formatDate($res['check_in']);
          $checkOut = formatDate($res['check_out']);
          $paymentDate = $res['payment_date'] ? formatDate($res['payment_date']) : null;
        ?>
        <article class="card" role="listitem" tabindex="0" aria-label="Reservation for room <?= e($res['room_number']) ?>, status <?= e($res['status']) ?>">
          <p><strong>Room:</strong> <?= e($res['room_number']) ?> (<?= e($res['room_type']) ?>)</p>
          <p><strong>Check-in:</strong> <?= e($checkIn) ?></p>
          <p><strong>Check-out:</strong> <?= e($checkOut) ?></p>
          <p><strong>Status:</strong>
            <span class="status-badge <?= $resStatusClass ?>"><?= e(ucfirst($res['status'])) ?></span>
          </p>
          <p><strong>Payment:</strong>
            <?php if ($res['payment_status']): ?>
              <span class="status-badge <?= $payStatusClass ?>"><?= e(ucfirst($res['payment_status'])) ?></span><br />
              Amount: ₱<?= number_format($res['amount_paid'], 2) ?><br />
              Date: <?= e($paymentDate) ?>
            <?php else: ?>
              <span class="status-badge pending">Pending</span>
            <?php endif; ?>
          </p>
          <?php if ($res['status'] === 'reserved' && empty($res['payment_status'])): ?>
            <form method="POST" action="php/reservation/cancel_reservation.php" onsubmit="return confirm('Are you sure you want to cancel this reservation?');" aria-label="Cancel reservation form">
              <input type="hidden" name="reservation_id" value="<?= e($res['reservation_id']) ?>" />
              <button class="cancel-btn" type="submit" aria-describedby="cancel-desc-<?= e($res['reservation_id']) ?>">Cancel Reservation</button>
              <span id="cancel-desc-<?= e($res['reservation_id']) ?>" class="sr-only">Cancel this reservation</span>
            </form>
          <?php endif; ?>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>
<style>
  .sr-only {
    position: absolute !important;
    width: 1px !important;
    height: 1px !important;
    padding: 0 !important;
    margin: -1px !important;
    overflow: hidden !important;
    clip: rect(0,0,0,0) !important;
    white-space: nowrap !important;
    border: 0 !important;
  }
</style>
</body>
</html>

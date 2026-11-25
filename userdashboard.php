<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php');
    exit();
}
require 'php/db.php';
$stmt = $pdo->prepare("SELECT full_name FROM users WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Dashboard - Paradise Hotel</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Open+Sans&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    font-family: 'Poppins', sans-serif;
    background-image: url("image/bg7.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    flex-direction: column;
  }
  header {
    background: rgba(0, 0, 0, 0.8);
    color: gold;
    padding: 1rem 2rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
  }

  .logo h2 {
    font-family: 'Cinzel', serif;
    font-size: 1.8rem;
    margin: 0;
  }

  nav a {
    color: gold;
    margin-left: 20px;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s;
  }

  nav a:hover, nav a.active {
    color: #fff3cd;
  }

  .hero {
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    text-shadow: 2px 2px 8px #000;
    text-align: center;
    padding: 1rem;
  }

  .hero h1 {
    font-family: 'Cinzel', serif;
    font-size: 3rem;
    letter-spacing: 1px;
  }

  main {
    flex: 1;
    padding: 5rem 1rem;
    text-align: center;
    background: rgba(255, 255, 255, 0.9);
    width: 90%;
    max-width: 1090px;
    margin: 2rem auto 1rem;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
  }

  main h2 {
    font-family: 'Cinzel', serif;
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: #222;
  }

  main p {
    font-family: 'Poppins', sans-serif;
    margin-bottom: 2rem;
    color: #555;
    font-size: 1.2rem;
  }

  .dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    padding: 1rem;
  }

  .card {
    background: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
    border-left: 5px solid gold;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
  }

  .card h3 {
    font-family: 'Cinzel', serif;
    font-size: 1.6rem;
    margin-bottom: 0.5rem;
    color: #222;
  }

  .card p {
    font-family: 'Poppins', sans-serif;
    color: #666;
    font-size: 1rem;
  }

  footer {
    background: #1c1c1c;
    color: #ccc;
    text-align: center;
    padding: 1rem;
    font-size: 0.9rem;
    margin-top: auto;
  }

  @media (max-width: 600px) {
    .hero h1 {
      font-size: 2.2rem;
    }
    header {
      flex-direction: column;
      align-items: flex-start;
      padding: 1rem;
    }
    nav {
      margin-top: 0.5rem;
      width: 100%;
    }
    nav a {
      display: inline-block;
      margin: 10px 10px 0 0;
    }
    main {
      margin: 1rem;
      padding: 1.2rem;
    }
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
  <div class="hero">
    <h1>Welcome to Paradise</h1>
  </div>
  <main>
    <h2>Welcome, <?= htmlspecialchars($user['full_name'] ?? 'Guest') ?>!</h2>
    <p>Explore our luxurious rooms and manage your reservations with ease.</p>
    <div class="dashboard-grid">
      <div class="card" onclick="navigate('view_rooms')" tabindex="0" role="button" aria-pressed="false">
        <h3>Available Rooms</h3>
        <p>Browse and reserve your perfect room.</p>
      </div>
      <div class="card" onclick="navigate('view_reservation')" tabindex="0" role="button" aria-pressed="false">
        <h3>My Reservations</h3>
        <p>View and manage your bookings.</p>
      </div>
    </div>
  </main>
  <footer>
    &copy; <?= date('Y') ?> Paradise Hotel. All rights reserved.
  </footer>
  <script>
    function navigate(page) {
      window.location.href = page + '.php';
    }
  </script>
</body>
</html>

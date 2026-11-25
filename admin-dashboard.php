<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome To Paradise Hotel</title>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous"
  />
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-image: url('image/bg9.jpg');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center center;
      color: #4a4539;
      line-height: 1.5;
    }

    header {
      background-color: rgba(255, 255, 255, 0.9);
      box-shadow: 0 3px 10px rgb(0 0 0 / 0.1);
      padding: 25px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .logo h2 {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 1.9rem;
      color: #b89452;
      margin: 0;
      letter-spacing: 1.2px;
    }

    nav {
      display: flex;
      align-items: center;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    nav a {
      font-weight: 600;
      color: #7a6a44;
      margin-left: 30px;
      font-size: 1.05rem;
      text-decoration: none;
      padding-bottom: 5px;
      position: relative;
      transition: color 0.3s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    nav a i {
      color: #b89452;
      font-size: 1.2rem;
    }

    nav a.active,
    nav a:hover {
      color: #b89452;
    }

    nav a.active::after,
    nav a:hover::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      height: 2.5px;
      width: 100%;
      background-color: #b89452;
      border-radius: 2px;
    }

    section.dashboard-content {
      background: rgba(197, 191, 136, 0.9);
      border-radius: 16px;
      box-shadow: 0 6px 20px rgb(184 148 82 / 0.25);
      padding: 40px 30px;
      margin: 60px auto;
      width: 90%;
      max-width: 1200px;
    }

    section.dashboard-content h2 {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 2.2rem;
      margin-bottom: 8px;
      color:rgb(255, 255, 255);
      text-align: center;
    }

    section.dashboard-content p {
      font-family: Georgia, serif;
      font-size: 1.20rem;
      margin-bottom: 40px;
      color:rgb(255, 255, 255);
      text-align: center;
    }

    .dashboard-options {
      display: flex;
      justify-content: center;
    }

    .option {
      background: #fff;
      border-radius: 14px;
      padding: 30px 40px;
      box-shadow: 0 6px 20px rgb(184 148 82 / 0.25);
      width: 100%;
      max-width: 900px;
    }

    section.dashboard-stats h3 {
      font-family: Georgia, serif;
      font-weight: 700;
      font-size: 1.7rem;
      color: #b89452;
      margin-bottom: 28px;
      text-align: center;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 24px;
    }

    .stat-box {
      background:rgba(252, 250, 246, 0.08);
      border: 1.8px solid #d9cfa7;
      border-radius: 12px;
      padding: 28px 20px 28px 60px;
      font-weight: 600;
      font-size: 1.15rem;
      color: #6e6043;
      position: relative;
      box-shadow: 0 3px 10px rgb(184 148 82 / 0.15);
      transition: box-shadow 0.3s ease;
      cursor: default;
    }

    .stat-box:hover {
      box-shadow: 0 8px 25px rgb(184 148 82 / 0.35);
    }

    #totalUsers::before,
    #totalReservations::before,
    #totalRooms::before,
    #availableRooms::before,
    #totalPayments::before {
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 1.8rem;
      color: #b89452;
    }

    #totalUsers::before {
      content: "\f0c0";
    }

    #totalReservations::before {
      content: "\f133";
    }

    #totalRooms::before {
      content: "\f236";
    }

    #availableRooms::before {
      content: "\f00c";
    }

    #totalPayments::before {
      content: "\f09d";
    }

    footer {
      margin-top: 150px;
      padding: 18px 0;
      background:rgb(172, 167, 142);
      text-align: center;
      font-weight: 600;
      font-size: 1rem;
      color:rgb(232, 229, 222);
      box-shadow: 0 -3px 8px rgb(184 148 82 / 0.18);
    }

    @media (max-width: 650px) {
      header {
        flex-wrap: wrap;
        padding: 20px;
      }

      nav {
        width: 100%;
        margin-top: 15px;
      }

      nav a {
        margin-left: 15px;
        font-size: 1rem;
      }

      section.dashboard-content {
        margin: 30px 15px;
      }

      .dashboard-options {
        flex-direction: column;
        align-items: center;
      }

      .option {
        padding: 25px 25px;
        max-width: 100%;
      }
    }
  </style>
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
    <h2>Welcome, Admin!</h2>
    <p>Here you can manage all aspects of the hotel reservation system.</p>

    <div class="dashboard-options">
      <div class="option">
        <section class="dashboard-stats">
          <h3>System Statistics</h3>
          <div class="stats-grid">
            <div class="stat-box" id="totalUsers">Total Users: Loading...</div>
            <div class="stat-box" id="totalReservations">Total Reservations: Loading...</div>
            <div class="stat-box" id="totalRooms">Total Rooms: Loading...</div>
            <div class="stat-box" id="availableRooms">Available Rooms: Loading...</div>
            <div class="stat-box" id="totalPayments">Total Payments: Loading...</div>
          </div>
        </section>
      </div>
    </div>
  </section>
  <footer>
    <p>&copy; 2025 Paradise Hotel. All rights reserved.</p>
  </footer>
  <script src="jquery/jquery.min.js"></script>
  <script src="jquery/admin/admindashboard.js"></script>
</body>
</html>

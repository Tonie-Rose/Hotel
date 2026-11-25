<?php
require_once 'php/db.php';

$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous"
  />
</head>
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
      background-color: #fff;
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
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f4f7fc;
  color: #333;
  margin: 0;
  padding: 0;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  line-height: 1.6;
}

.dashboard-content {
  background: #fff;
  padding: 35px 30px;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
  margin: 40px auto;
  max-width: 1200px;
  transition: box-shadow 0.3s ease;
}

.dashboard-content:hover {
  box-shadow: 0 15px 45px rgba(0, 0, 0, 0.12);
}

.dashboard-content h2 {
  font-weight: 700;
  font-size: 2.3rem;
  margin-bottom: 10px;
  color: #222;
  letter-spacing: 0.03em;
  text-transform: uppercase;
  border-bottom: 3px solid #007bff;
  padding-bottom: 8px;
}

.dashboard-content p {
  margin-bottom: 30px;
  font-size: 1.1rem;
  color: #555;
  max-width: 800px;
}
.styled-table {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0 12px;
  font-size: 1rem;
  min-width: 700px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
  border-radius: 16px;
  overflow: hidden;
  background: #fafbfc;
  transition: transform 0.2s ease;
}

.styled-table:hover {
  transform: translateY(-4px);
}

.styled-table thead tr {
  background-color: #007bff;
  color: #fff;
  text-align: left;
  font-weight: 700;
  font-size: 1.05rem;
  user-select: none;
}

.styled-table thead th {
  padding: 18px 25px;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

.styled-table tbody tr {
  background-color: #fff;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.07);
  transition: background-color 0.3s ease, box-shadow 0.3s ease;
  cursor: default;
  border-radius: 10px;
}

.styled-table tbody tr:hover {
  background-color: #e6f0ff;
  box-shadow: 0 6px 18px rgba(0, 123, 255, 0.2);
}

.styled-table tbody td {
  padding: 16px 25px;
  vertical-align: middle;
  color: #444;
  border-left: 1px solid #e0e6ef;
}

.styled-table tbody td:first-child {
  border-left: none;
}
.styled-table tbody tr td[colspan] {
  text-align: center;
  font-style: italic;
  color: #888;
  padding: 30px 20px;
  font-size: 1.1rem;
}
button.view-history-btn,
button.delete-btn {
  padding: 9px 18px;
  border-radius: 8px;
  border: none;
  cursor: pointer;
  font-weight: 700;
  font-size: 0.95rem;
  transition: all 0.3s ease;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
  user-select: none;
}

button.view-history-btn {
  background: linear-gradient(45deg, #17a2b8, #138496);
  color: #fff;
  box-shadow: 0 5px 12px rgba(23, 162, 184, 0.5);
}

button.view-history-btn:hover,
button.view-history-btn:focus {
  background: linear-gradient(45deg, #138496, #0f6674);
  box-shadow: 0 7px 18px rgba(15, 102, 116, 0.7);
  outline: none;
}

button.delete-btn {
  background: linear-gradient(45deg, #dc3545, #b02a37);
  color: #fff;
  box-shadow: 0 5px 12px rgba(220, 53, 69, 0.5);
}

button.delete-btn:hover,
button.delete-btn:focus {
  background: linear-gradient(45deg, #b02a37, #8c212a);
  box-shadow: 0 7px 18px rgba(140, 33, 42, 0.7);
  outline: none;
}
.modal {
  display: none;
  position: fixed;
  z-index: 11000;
  left: 0; top: 0;
  width: 100vw; height: 100vh;
  background-color: rgba(0, 0, 0, 0.65);
  overflow-y: auto;
  padding: 60px 20px;
  box-sizing: border-box;
  backdrop-filter: blur(4px);
  -webkit-backdrop-filter: blur(4px);
  animation: fadeInModal 0.3s ease forwards;
}

@keyframes fadeInModal {
  from {opacity: 0;}
  to {opacity: 1;}
}

.modal-content {
  background-color: #fff;
  margin: 0 auto;
  padding: 35px 40px;
  border-radius: 20px;
  width: 90%;
  max-width: 900px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
  position: relative;
  transform: translateY(-15px);
  animation: slideInModal 0.4s ease forwards;
}

@keyframes slideInModal {
  from {opacity: 0; transform: translateY(-25px);}
  to {opacity: 1; transform: translateY(0);}
}

.modal-content h3 {
  margin-top: 0;
  margin-bottom: 25px;
  font-weight: 700;
  font-size: 2rem;
  color: #007bff;
  letter-spacing: 0.05em;
  text-transform: uppercase;
}
.close-btn {
  position: absolute;
  right: 25px;
  top: 25px;
  font-size: 32px;
  font-weight: 700;
  color: #666;
  cursor: pointer;
  transition: color 0.3s ease;
  user-select: none;
}

.close-btn:hover {
  color: #007bff;
  transform: scale(1.15);
}
#bookingHistoryTable {
  width: 100%;
  border-collapse: collapse;
  font-size: 1rem;
  color: #333;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
}

#bookingHistoryTable thead tr {
  background-color: #007bff;
  color: #fff;
  font-weight: 700;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

#bookingHistoryTable thead th,
#bookingHistoryTable tbody td {
  padding: 15px 20px;
  border: 1px solid #ddd;
  text-align: center;
  user-select: none;
}

#bookingHistoryTable tbody tr:nth-child(even) {
  background-color: #f1f6ff;
}

#bookingHistoryTable tbody tr:hover {
  background-color: #dbe9ff;
  transition: background-color 0.25s ease;
}
@media (max-width: 1024px) {
  .dashboard-content {
    padding: 25px 20px;
    max-width: 95%;
  }

  .styled-table {
    min-width: 100%;
    font-size: 0.9rem;
  }
}
@media (max-width: 768px) {
  .styled-table thead {
    display: none; 
  }
  .styled-table, 
  .styled-table tbody, 
  .styled-table tr, 
  .styled-table td {
    display: block;
    width: 100%;
  }
  .styled-table tr {
    margin-bottom: 25px;
    background: #fff;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
    border-radius: 16px;
    padding: 20px 15px;
  }
  .styled-table td {
    padding-left: 50%;
    position: relative;
    text-align: left;
    border: none;
    border-bottom: 1px solid #eee;
  }
  .styled-table td:last-child {
    border-bottom: 0;
  }
  .styled-table td::before {
    content: attr(data-label);
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    font-weight: 600;
    color: #007bff;
    text-transform: uppercase;
  }
  button.view-history-btn,
  button.delete-btn {
    width: 48%;
    margin-right: 4%;
    margin-bottom: 10px;
    font-size: 0.9rem;
  }
}
@media (max-width: 480px) {
  button.view-history-btn,
  button.delete-btn {
    width: 100%;
    margin-right: 0;
  }
}
    footer {
      margin-top: 250px;
      padding: 18px 0;
      background:rgb(172, 167, 142);
      text-align: center;
      font-weight: 600;
      font-size: 1rem;
      color:rgb(232, 229, 222);
      box-shadow: 0 -3px 8px rgb(184 148 82 / 0.18);
    }
</style>
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
        <h2>User Management</h2>
        <p>List of all registered users:</p>
        <div class="dashboard-options">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['full_name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <button class="view-history-btn" data-id="<?= $user['user_id'] ?>">View History</button>
                                <button class="delete-btn" data-id="<?= $user['user_id'] ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="4">No users found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <div id="bookingHistoryModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h3>User Booking History</h3>
            <table id="bookingHistoryTable" border="1" width="100%" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Paradise Hotel. All rights reserved.</p>
    </footer>
    <script src="jquery/jquery.min.js"></script>
    <script src="jquery/admin/manage_users.js"></script>
</body>
</html>

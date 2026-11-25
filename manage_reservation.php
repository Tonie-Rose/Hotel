<?php
require_once 'php/db.php';
$stmt = $pdo->query("SELECT r.*, ro.room_number, ro.room_type, u.full_name
                     FROM reservations r 
                     JOIN rooms ro ON r.room_id = ro.room_id
                     JOIN users u ON r.user_id = u.user_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="css/manage_reservation.css" />
  <title>Manage Reservations</title>
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
  <h1>RESERVATION'S MANAGEMENT</h1>
  <table>
    <thead>
      <tr>
        <th>User Name</th>
        <th>Room ID</th>
        <th>Room Number</th>
        <th>Room Type</th>
        <th>Check-in</th>
        <th>Check-out</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $stmt->fetch()) : ?>
        <tr>
          <td><?= htmlspecialchars($row['full_name']) ?></td>
          <td><?= htmlspecialchars($row['room_id']) ?></td>
          <td><?= htmlspecialchars($row['room_number']) ?></td>
          <td><?= htmlspecialchars($row['room_type']) ?></td>
          <td><?= htmlspecialchars($row['check_in']) ?></td>
          <td><?= htmlspecialchars($row['check_out']) ?></td>
          <td><?= htmlspecialchars($row['status']) ?></td>
          <td>
            <button class="edit-btn" data-id="<?= $row['reservation_id'] ?>">Edit</button>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <div id="overlay"></div>
  <div id="editModal">
    <h3>Edit Reservation</h3>
    <form id="editForm">
      <input type="hidden" name="reservation_id" id="reservation_id">
      <label>Check-in Date:</label>
      <input type="date" name="checkin_date" id="check_in" required>
      <label>Check-out Date:</label>
      <input type="date" name="checkout_date" id="check_out" required>
      <label>Status:</label>
      <select name="status" id="status" required>
        <option value="Pending">Pending</option>
        <option value="Confirmed">Confirmed</option>
        <option value="Cancelled">Cancelled</option>
      </select>
      <button type="submit" class="submit-btn">Update</button>
      <button type="button" class="close-btn">Cancel</button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function () {
    $('.edit-btn').on('click', function () {
      const row = $(this).closest('tr');
      const id = $(this).data('id');

      $('#reservation_id').val(id);
      $('#check_in').val(row.find('td').eq(5).text().trim());
      $('#check_out').val(row.find('td').eq(6).text().trim());
      $('#status').val(row.find('td').eq(7).text().trim());

      $('#editModal').show();
    });
    $('.close-btn').on('click', function () {
      $('#editModal').hide();
    });
    $('#editForm').on('submit', function (e) {
      e.preventDefault();
      $.ajax({
        url: 'php/reservation/update_reservation.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function (response) {
          if (response === 'success') {
            alert('Reservation updated successfully!');
            location.reload();
          } else if (response === 'paid') {
            alert('Cannot update. Reservation is already paid.');
          } else if (response === 'missing_data') {
            alert('Please fill in all required fields.');
          } else {
            alert('Update failed: ' + response);
          }
        },
        error: function () {
          alert('An unexpected error occurred.');
        }
      });
    });
    $('.delete-btn').on('click', function () {
      const id = $(this).data('id');
      if (confirm('Cancel this reservation?')) {
        $.ajax({
          url: 'php/reservation/delete_reservation.php',
          method: 'POST',
          data: { reservation_id: id },
          dataType: 'json',
          success: function (response) {
            alert(response.message);
            if (response.success) location.reload();
          },
          error: function () {
            alert('An error occurred.');
          }
        });
      }
    });
  });
  </script>
</body>
</html>

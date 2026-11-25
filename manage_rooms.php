<?php
require_once 'php/db.php';
$stmt = $pdo->query("SELECT * FROM rooms ORDER BY room_number");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/manage_room.css" />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    crossorigin="anonymous"
  />
  <title>Manage Rooms</title>
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
<div class="container mt-4">
  <h1>ROOM'S MANAGEMENT</h1>
  <button id="btnAddRoom" class="btn btn-primary mb-4">+ Add Room</button>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Room Number</th>
        <th>Type</th>
        <th>Bed Type</th>
        <th>Capacity</th>
        <th>Floor</th>
        <th>Price</th>
        <th>Status</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="roomTableBody">
      <?php foreach ($rooms as $room): ?>
        <tr data-id="<?= htmlspecialchars($room['room_id']) ?>">
          <td><?= htmlspecialchars($room['room_number']) ?></td>
          <td><?= htmlspecialchars($room['room_type']) ?></td>
          <td><?= htmlspecialchars($room['bed_type']) ?></td>
          <td><?= htmlspecialchars($room['capacity']) ?></td>
          <td><?= htmlspecialchars($room['floor']) ?></td>
          <td><?= htmlspecialchars($room['price']) ?></td>
          <td><?= htmlspecialchars($room['status']) ?></td>
          <td><?= htmlspecialchars($room['description']) ?></td>
          <td>
            <button class="btn btn-sm btn-info btn-edit" data-id="<?= htmlspecialchars($room['room_id']) ?>">Edit</button>
            <button class="btn btn-sm btn-danger btn-delete" data-id="<?= htmlspecialchars($room['room_id']) ?>">Delete</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="addRoomForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addRoomLabel">Add New Room</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="add_room_number" class="form-label">Room Number</label>
          <input type="text" name="room_number" id="add_room_number" class="form-control" required placeholder="E.g. 101" />
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="add_room_type" class="form-label">Room Type</label>
            <select name="room_type" id="add_room_type" class="form-select" required>
              <option value="">-- Select Type --</option>
              <option value="Single">Single</option>
              <option value="Double">Double</option>
              <option value="Suite">Suite</option>
              <option value="Deluxe">Deluxe</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label for="add_bed_type" class="form-label">Bed Type</label>
            <select name="bed_type" id="add_bed_type" class="form-select" required>
              <option value="">-- Select Bed Type --</option>
              <option value="Single">Single</option>
              <option value="Double">Double</option>
              <option value="Queen">Queen</option>
              <option value="King">King</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="add_capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" id="add_capacity" class="form-control" min="1" required placeholder="E.g. 2" />
          </div>
          <div class="col-md-4 mb-3">
            <label for="add_floor" class="form-label">Floor</label>
            <input type="number" name="floor" id="add_floor" class="form-control" min="0" required placeholder="E.g. 1" />
          </div>
          <div class="col-md-4 mb-3">
            <label for="add_price" class="form-label">Price (₱)</label>
            <input type="number" name="price" id="add_price" class="form-control" min="0" step="0.01" required placeholder="E.g. 1500.00" />
          </div>
        </div>
        <div class="mb-3">
          <label for="add_status" class="form-label">Status</label>
          <select name="status" id="add_status" class="form-select" required>
            <option value="">-- Select Status --</option>
            <option value="Available">Available</option>
            <option value="Booked">Booked</option>
            <option value="Maintenance">Maintenance</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="add_description" class="form-label">Description</label>
          <textarea name="description" id="add_description" class="form-control" rows="3" placeholder="Write a short description (optional)"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Add Room</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editRoomForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editRoomLabel">Edit Room</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="edit_room_id" name="room_id" />
        <div class="mb-3">
          <label for="edit_room_number" class="form-label">Room Number</label>
          <input type="text" name="room_number" id="edit_room_number" class="form-control" required placeholder="E.g. 101" />
        </div>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="edit_room_type" class="form-label">Room Type</label>
            <select name="room_type" id="edit_room_type" class="form-select" required>
              <option value="">-- Select Type --</option>
              <option value="Single">Single</option>
              <option value="Double">Double</option>
              <option value="Suite">Suite</option>
              <option value="Deluxe">Deluxe</option>
            </select>
          </div>
          <div class="col-md-6 mb-3">
            <label for="edit_bed_type" class="form-label">Bed Type</label>
            <select name="bed_type" id="edit_bed_type" class="form-select" required>
              <option value="">-- Select Bed Type --</option>
              <option value="Single">Single</option>
              <option value="Double">Double</option>
              <option value="Queen">Queen</option>
              <option value="King">King</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="edit_capacity" class="form-label">Capacity</label>
            <input type="number" name="capacity" id="edit_capacity" class="form-control" min="1" required placeholder="E.g. 2" />
          </div>
          <div class="col-md-4 mb-3">
            <label for="edit_floor" class="form-label">Floor</label>
            <input type="number" name="floor" id="edit_floor" class="form-control" min="0" required placeholder="E.g. 1" />
          </div>
          <div class="col-md-4 mb-3">
            <label for="edit_price" class="form-label">Price (₱)</label>
            <input type="number" name="price" id="edit_price" class="form-control" min="0" step="0.01" required placeholder="E.g. 1500.00" />
          </div>
        </div>
        <div class="mb-3">
          <label for="edit_status" class="form-label">Status</label>
          <select name="status" id="edit_status" class="form-select" required>
            <option value="">-- Select Status --</option>
            <option value="Available">Available</option>
            <option value="Booked">Booked</option>
            <option value="Maintenance">Maintenance</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="edit_description" class="form-label">Description</label>
          <textarea name="description" id="edit_description" class="form-control" rows="3" placeholder="Write a short description (optional)"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update Room</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="jquery/jquery.min.js"></script>
<script src="jquery/admin/manage_rooms.js"></script>
</body>
</html>

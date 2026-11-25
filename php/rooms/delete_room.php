<?php
require_once '../db.php';

$response = ['success' => false, 'message' => 'Delete failed'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $room_id = intval($_POST['room_id'] ?? 0);

  if ($room_id <= 0) {
    $response['message'] = 'Invalid room ID.';
  } else {
    try {
      $stmt = $pdo->prepare("DELETE FROM rooms WHERE room_id = ?");
      $stmt->execute([$room_id]);
      if ($stmt->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = 'Room deleted successfully.';
      } else {
        $response['message'] = 'Room not found.';
      }
    } catch (PDOException $e) {
      $response['message'] = 'Database error: ' . $e->getMessage();
    }
  }
}

header('Content-Type: application/json');
echo json_encode($response);

<?php
require_once '../db.php';

$response = ['success' => false, 'message' => 'Room not found'];

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $stmt = $pdo->prepare("SELECT * FROM rooms WHERE room_id = ?");
  $stmt->execute([$id]);
  $room = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($room) {
    $response['success'] = true;
    $response['room'] = $room;
  }
}

header('Content-Type: application/json');
echo json_encode($response);

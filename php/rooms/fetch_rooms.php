<?php
require_once '../db.php';

$response = ['success' => false, 'rooms' => []];

try {
  $stmt = $pdo->query("SELECT * FROM rooms ORDER BY room_number ASC");
  $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $response['success'] = true;
  $response['rooms'] = $rooms;
} catch (PDOException $e) {
  $response['message'] = 'Database error: ' . $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);

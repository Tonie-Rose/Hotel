<?php
require_once __DIR__ . '/../db.php';  // Adjust relative path if needed

header('Content-Type: application/json');

$user_id = $_POST['user_id'] ?? 0;

if (!$user_id) {
    echo json_encode([]);
    exit;
}

$sql = "
  SELECT r.reservation_id, r.check_in, r.check_out, r.status, rm.room_number, rm.room_type
  FROM reservations r
  JOIN rooms rm ON r.room_id = rm.room_id
  WHERE r.user_id = :user_id
  ORDER BY r.check_in DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($reservations);

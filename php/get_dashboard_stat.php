<?php
require_once 'db.php';  // Already in the same php/ folder

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT 
            (SELECT COUNT(*) FROM users) AS total_users,
            (SELECT COUNT(*) FROM reservations) AS total_reservations,
            (SELECT COUNT(*) FROM rooms) AS total_rooms,
            (SELECT COUNT(*) FROM rooms WHERE status = 'available') AS available_rooms,
            (SELECT IFNULL(SUM(amount_paid), 0) FROM payments) AS total_payments
    ");

    $stats = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $stats
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

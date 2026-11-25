<?php
require 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');
$role = trim($_POST['role'] ?? '');

if (!$email || !$password || !$role) {
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

try {
    if ($role === 'admin') {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    }
    $stmt->execute([$email, $password]);

    if ($stmt->rowCount() > 0) {
        session_start();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($role === 'admin') {
        $_SESSION['user_id'] = $data['admin_id'];
        $_SESSION['user_name'] = $data['full_name']; // Assuming admin also has 'full_name'
    } else {
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['user_name'] = $data['full_name']; // ✅ This fixes your issue
    }
    $_SESSION['role'] = $role;


        $redirect = $role === 'admin' ? 'admin-dashboard.php' : 'userdashboard.php';
        echo json_encode(['success' => true, 'redirect' => $redirect]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>

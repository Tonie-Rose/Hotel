<?php
include '../db.php'; // adjust path as needed (e.g. '../db.php' or '../../db.php')

// Only run if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reservation_id'], $_POST['checkin_date'], $_POST['checkout_date'], $_POST['status'])) {
        $reservation_id = $_POST['reservation_id'];
        $checkin_date = $_POST['checkin_date'];
        $checkout_date = $_POST['checkout_date'];
        $status = $_POST['status'];

        try {
            // Prevent updates if already paid
            $check = $pdo->prepare("SELECT payment_status FROM payments WHERE reservation_id = ?");
            $check->execute([$reservation_id]);
            $payment = $check->fetch();

            if ($payment && $payment['payment_status'] === 'Paid') {
                echo 'paid';
                exit;
            }

            // ✅ Use correct column names here
            $stmt = $pdo->prepare("UPDATE reservations SET check_in = ?, check_out = ?, status = ? WHERE reservation_id = ?");
            $stmt->execute([$checkin_date, $checkout_date, $status, $reservation_id]);

            echo "success";
        } catch (PDOException $e) {
            echo "error: " . $e->getMessage();
        }
    } else {
        echo "missing_data";
    }
} else {
    echo "invalid_request";
}
?>

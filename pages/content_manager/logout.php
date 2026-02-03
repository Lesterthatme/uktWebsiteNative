<?php
session_start();
include '../../connection/dbconnection.php';

date_default_timezone_set('Asia/Phnom_Penh');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $update = "UPDATE user_account SET session_token = '' WHERE user_id = ?";
    $stmt = $conn->prepare($update);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }

    $query = "SELECT username FROM user_account WHERE user_id = ?";
    $statement = $conn->prepare($query);
    if ($statement) {
        $statement->bind_param("i", $user_id);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $description = "Account Logged out";
            $log_date = date('Y-m-d');
            $log_time = date('H:i:s');

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_query);
            if ($log_stmt) {
                $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $user_id);
                $log_stmt->execute();
                $log_stmt->close();
            }
        }
        $statement->close();
    }
}

session_unset();
session_destroy();

header('Location: login');
exit;
?>

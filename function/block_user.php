<?php
session_start();
include '../connection/dbconnection.php';

// Set timezone to Cambodia
date_default_timezone_set('Asia/Phnom_Penh');

if (!isset($_SESSION['session_token']) || !isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit;
}

$admin_user_id = $_SESSION['user_id']; 

if (isset($_GET['user_id'])) {
    $blocked_user_id = intval($_GET['user_id']);

    $userQuery = "SELECT username FROM user_account WHERE user_id = ?";
    $userStmt = $conn->prepare($userQuery);
    $userStmt->bind_param("i", $blocked_user_id);
    $userStmt->execute();
    $userStmt->bind_result($blocked_username);
    $userStmt->fetch();
    $userStmt->close();

    if ($blocked_username) {
        $query = "UPDATE user_account SET account_status = 'blocked' WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $blocked_user_id);

        if ($stmt->execute()) {
            $description = "Blocked user $blocked_username.";
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $logStmt = $conn->prepare($logQuery);
            $logStmt->bind_param("sssi", $description, $log_date, $log_time, $admin_user_id);
            $logStmt->execute();
            $logStmt->close();

            // Toast Success Alert
            $_SESSION['toastMsg'] = "User account has been blocked successfully.";
            $_SESSION['toastType'] = "toast-success";
        } else {
            // Toast Error Alert
            $_SESSION['toastMsg'] = "Error blocking user.";
            $_SESSION['toastType'] = "toast-error";
        }

        $stmt->close();
    } else {
        // Toast Error Alert for User Not Found
        $_SESSION['toastMsg'] = "User not found.";
        $_SESSION['toastType'] = "toast-error";
    }

    $conn->close();
    header("Location: ../pages/adminukt/approved_account");
    exit();
}
?>

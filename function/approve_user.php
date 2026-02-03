<?php
session_start(); 
include '../connection/dbconnection.php';

// Set the timezone to Cambodia (Asia/Phnom_Penh)
date_default_timezone_set('Asia/Phnom_Penh');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/adminukt/login.php");
    exit();
}

$admin_id = $_SESSION['user_id']; 

// approve user function  start
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Fetch user details
    $query = "SELECT username, user_type FROM user_account WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user) {
        $username = $user['username'];
        $user_type = $user['user_type'];

        // Approve user
        $sql = "UPDATE user_account SET account_status = 'approved' WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // Log the action
            $description = "Approved " . $username . " as " . $user_type;
            $log_date = date('Y-m-d'); 
            $log_time = date('H:i:s'); 

            $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $admin_id);
            $log_stmt->execute();
            $log_stmt->close();

            $_SESSION['toastMsg'] = "User approved successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error approving user.";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "User not found.";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../pages/adminukt/approved_account"); // Redirect to pending accounts page
    exit();
} else {
    header("Location: ../pages/adminukt/approved_account");
    exit();
}
// approve user function  End
?>

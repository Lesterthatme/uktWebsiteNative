<?php
session_start();
include '../connection/dbconnection.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/adminukt/login.php");
    exit();
}
// approve user function  start
if (isset($_GET['user_id'])) {
    $conn->begin_transaction();
    try {
        $admin_id = $_SESSION['user_id'];
        $user_id = $_GET['user_id'];

        // Fetch user details
        $query = "SELECT username, user_type FROM user_account WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $username = $user['username'];
            $user_type = $user['user_type'];

            // Approve user
            $sql = "UPDATE user_account SET account_status = 'approved' WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);

            if (!$stmt->execute()) {
                // Log the action
                $_SESSION['toastMsg'] = "Error approving user.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/approved_account");
                exit;
            }

            $description = "Approved " . $username . " as " . $user_type;
            $log_date = date('Y-m-d');
            $log_time = date('H:i:s');

            $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $admin_id);
            if (!$log_stmt->execute()) {
                $_SESSION['toastMsg'] = "Trail Error.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/approved_account");
                exit;
            }

            $conn->commit();
            $_SESSION['toastMsg'] = "User approved successfully!";
            $_SESSION['toastType'] = "toast-success";
            header("Location: ../pages/adminukt/approved_account"); // Redirect to pending accounts page
            exit();
        } else {
            $_SESSION['toastMsg'] = "User Not Found!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/approved_account"); // Redirect to pending accounts page
            exit();
        }
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: ../pages/adminukt/approved_account");
        exit;
    }
} else {
    header("Location: ../pages/adminukt/approved_account");
    exit();
}
// approve user function  End

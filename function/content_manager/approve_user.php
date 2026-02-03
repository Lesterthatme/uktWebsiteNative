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

    $query = "SELECT username, user_type FROM user_account WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user) {
        $username = $user['username'];
        $user_type = $user['user_type'];

        $sql = "UPDATE user_account SET account_status = 'approved' WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            $description = "Approved " . $username . " as " . $user_type . "";
            $log_date = date('Y-m-d'); 
            $log_time = date('H:i:s'); 
            
            $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $log_stmt = $conn->prepare($log_sql);
            $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $admin_id);
            $log_stmt->execute();
            $log_stmt->close();

            echo "<script>
                    alert('User approved successfully.');
                    window.location.href = '../pages/adminukt/pending_account';
                  </script>";
        } else {
            echo "<script>
                    alert('Error approving user.');
                    window.location.href = '../pages/adminukt/pending_account';
                  </script>";
        }
    } else {
        echo "<script>
                alert('User not found.');
                window.location.href = '../pages/adminukt/pending_account';
              </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../pages/adminukt/pending_account");
    exit();
}
// approve user function  End
?>

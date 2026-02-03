<?php 

//logout.php

session_start();
include '../../connection/dbconnection.php';

// Set Cambodian timezone
date_default_timezone_set('Asia/Phnom_Penh');

// Check if a user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch the username from user_account table
    $query = "SELECT username FROM user_account WHERE user_id = ?";
    $statement = $conn->prepare($query);
    if ($statement) {
        $statement->bind_param("i", $user_id);
        $statement->execute();
        $result = $statement->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];

            // Prepare the log description
            $description = " Account Logged out";
            $log_date = date('Y-m-d'); // Current date
            $log_time = date('H:i:s'); // Current time

            // Insert logout log into history_log table
            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $log_statement = $conn->prepare($log_query);
            if ($log_statement) {
                $log_statement->bind_param("sssi", $description, $log_date, $log_time, $user_id);
                $log_statement->execute();
                $log_statement->close();
            }
        }
        $statement->close();
    }
}

// Unset session and destroy it
session_unset();
session_destroy();

// Redirect to login page
header('location:login');
exit;

?>

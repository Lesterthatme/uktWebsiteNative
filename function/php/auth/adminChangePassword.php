<?php

session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/ukt' . '/connection/dbconnection.php';


if (isset($_POST['updatePassBtn'])) {
    $conn->begin_transaction();
    try {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $user_id = $_SESSION['user_id'];

        // Fetch the current password and user details from the database
        $query = "SELECT * FROM user_account WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $user_id);
        if (!$stmt->execute()) {
            header("Location: /ukt/pages/adminukt/view_profile.php?message=User not found.");
            exit;
        }
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Check if the entered current password matches the stored password
        if ($current_password === $user['password']) {
            // Check if the new password and confirm password match

            // Update the password in the database
            $query = "UPDATE user_account SET `password` = ? WHERE user_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('si', $new_password, $user_id);
            if ($stmt->execute()) {
                // Insert into history_log
                $description = "Password Updated";
                $log_date = date('Y-m-d'); // Cambodia date
                $log_time = date('H:i:s'); // Cambodia time

                $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
                $log_stmt = $conn->prepare($log_query);
                $log_stmt->bind_param('sssi', $description, $log_date, $log_time, $user_id);
                if (!$log_stmt->execute()) {
                    $conn->rollback();
                    header("Location: /ukt/pages/adminukt/view_profile.php?message=Trail Went Wrong.");
                    exit;
                }

                $conn->commit();
                header("Location: /ukt/pages/adminukt/view_profile.php");
                exit;
            } else {
                $conn->rollback();
                header("Location: /ukt/pages/adminukt/view_profile.php?message=User not found.");
                exit;
            }
        } else {
            $conn->rollback();
            header("Location: /ukt/pages/adminukt/view_profile.php?message=User's Password incorrect.");
            exit;
        }
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: /ukt/pages/adminukt/view_profile.php?message=Something Went Wrong.");
        exit;
    }
}

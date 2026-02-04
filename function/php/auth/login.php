<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/ukt' . '/connection/dbconnection.php';

if (isset($_POST["login_button"])) {

    $conn->begin_transaction();
    try {
        $login_value = $_POST["email"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT * FROM user_account WHERE (email = ? OR username = ?) AND `password` = ?");
        $stmt->bind_param("sss", $login_value, $login_value, $password);

        if (!$stmt->execute()) {
            header("Location: /ukt/pages/adminukt/login.php?message=Account not found.");
            exit;
        }

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['user_id'];

            if ($row['user_type'] !== 'Administrator') {
                header("Location: /ukt/pages/adminukt/login.php?message=You don't have a privilege to log in as an Administrator.");
                exit;
            }


            // bakit need pa neto e meron na ngang auto direct ngani (2026)
            if (!empty($row['session_token'])) {
                header("Location: /ukt/pages/adminukt/login.php?message=You are already logged in. Please log out the previous session.");
                exit;
            }

            // Generate and save session token
            session_regenerate_id();
            $session_token = session_id();
            $stmt2 = $conn->prepare("UPDATE user_account SET session_token = ? WHERE user_id = ?");
            $stmt2->bind_param("ss", $session_token, $userId);
            if (!$stmt2->execute()) {
                $conn->rollback();
                header("Location: /ukt/pages/adminukt/login.php?message=Backend Error #2");
                exit;
            }


            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['session_token'] = $session_token;

            // Logging
            $description = "Account Logged in";
            $log_date = date('Y-m-d');
            $log_time = date('H:i:s');
            $user_id = $row['user_id'];


            $stmt3 = $conn->prepare("INSERT INTO history_log (`description`, log_date, log_time, user_id) VALUES (?, ?, ?, ?)");
            $stmt3->bind_param("ssss", $description, $log_date, $log_time, $user_id);
            if (!$stmt3->execute()) {
                $conn->rollback();

                header("Location: /ukt/pages/adminukt/login.php?message=Backend Error #3");
                exit;
            }

            // Set Remember Me cookie (valid for 30 days)
            if (isset($_POST['remember'])) {
                setcookie("remember_me", $session_token, time() + (30 * 24 * 60 * 60), "/");
            } else {
                setcookie("remember_me", "", time() - 3600, "/");
            }

            $conn->commit();
            header("Location: /ukt/pages/adminukt/page_management.php");
            exit;
        }
    } catch (Exception $e) {
        $conn->rollback();
        header("Location: /ukt/pages/adminukt/login.php?message=Something Went Wrong. Please try again.");
        exit;
    }
}


if (isset($_POST['clear_session'])) {
    $identifier = trim($_POST['user_identifier']);

    // Prepare the query
    $query = "UPDATE user_account SET session_token = NULL WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $identifier, $identifier);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: /ukt/pages/adminukt/login.php?message=Session token cleared successfully.");
        } else {
            header("Location: /ukt/pages/adminukt/login.php?message=No user found with the provided username or email.");
        }
    } else {
        header("Location: /ukt/pages/adminukt/login.php?message=Something Went Wrong.");
    }
    exit;
}

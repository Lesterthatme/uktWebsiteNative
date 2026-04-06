<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/ukt' . '/connection/dbconnection.php';


// Remember me login
if (isset($_COOKIE['remember_me'])) {
    $session_token = $_COOKIE['remember_me'];

    $stmt = $conn->prepare("SELECT * FROM user_account WHERE session_token = ?");
    $stmt->bind_param("s", $session_token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['account_status'] === 'approved') {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['user_type'] = $user['user_type'];
        header("Location: page_management");
        exit();
    }
}



if (isset($_POST["login_button"])) {
    $conn->begin_transaction();
    try {

        $login_value = trim($_POST["email"]);
        $password = $_POST["password"];


        $stmt = $conn->prepare("SELECT * FROM user_account WHERE (email = ? OR username = ?) AND password = ?");
        $stmt->bind_param("sss", $login_value, $login_value, $password);
        if (!$stmt->execute()) {
            $conn->rollback();
            header('Location: /ukt/pages/content_manager/login.php?mess="Something Went Wrong to DB."');
            exit;
        }
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // if ($user['user_type'] !== 'Content manager') {
            //     echo "<script>alert('You don\\'t have a privilege to log in as a Content manager'); window.location.href = 'login';</script>";
            //     exit;
            // }

            // if ($user['account_status'] === 'pending') {
            //     echo "<script>alert('Your account is pending, wait for admin approval'); window.location.href = 'login';</script>";
            //     exit;
            // }

            // if ($user['account_status'] === 'blocked') {
            //     echo "<script>alert('Your account is blocked'); window.location.href = 'login';</script>";
            //     exit;
            // }

            // if (!empty($user['session_token'])) {
            //     echo "<script>alert('You are already logged in. Please log out the previous session.'); window.location.href = 'login';</script>";
            //     exit;
            // }

            // Login success
            session_regenerate_id();
            $session_token = session_id();

            $update = $conn->prepare("UPDATE user_account SET session_token = ? WHERE user_id = ?");
            $update->bind_param("si", $session_token, $user['user_id']);
            if (! $update->execute()) {
                $conn->rollback();
                header('Location: /ukt/pages/content_manager/login.php');
                exit;
            }

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['session_token'] = $session_token;

            // Log history
            $log_stmt = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)");
            $description = "Account Logged in";
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");
            $user_id = $user['user_id'];
            $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $user_id);
            if (! $log_stmt->execute()) {
                $conn->rollback();
                header('Location: /ukt/pages/content_manager/login.php');
                exit;
            }

            // Remember me using session_token
            if (isset($_POST['remember'])) {
                setcookie('remember_me', $session_token, time() + (30 * 24 * 60 * 60), "/");
            } else {
                setcookie('remember_me', '', time() - 3600, "/");
            }

            $conn->commit();
            header('Location: /ukt/pages/content_manager/page_management.php?success=true');
            exit;
        } else {
            header('Location: /ukt/pages/content_manager/login.php?mess="Password Not Matched."');
            exit;
        }
    } catch (Exception $e) {
        $conn->rollback();
        header('Location: ukt/pages/content_manager/login.php');
        exit;
    }
}

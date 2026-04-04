<?php
include '../../connection/dbconnection.php';
if (isset($_GET['forgot_password_code'])) {

    $forgot_password_code = $_GET['forgot_password_code'];

    $verifyQuery = $conn->query("SELECT * FROM user_account WHERE forgot_password_code = '$forgot_password_code' AND password_last_updated >= NOW() - INTERVAL 1 DAY");

    if ($verifyQuery->num_rows == 0) {
        header("Location: login.php");
        exit();
    }

    if (isset($_POST['change'])) {
        $email = $_POST['email'];
        $new_password = $_POST['new_password'];

        $changeQuery = $conn->query("UPDATE user_account SET password = '$new_password' WHERE email = '$email' AND forgot_password_code = '$forgot_password_code' AND password_last_updated >= NOW() - INTERVAL 1 DAY");

        if ($changeQuery) {
            header("Location: success.html");
        } else {
            echo 'Error: ' . $conn->error;
        }
    }
} else {
    header("Location: login.php");
    exit();
}

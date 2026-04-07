<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/ukt' . '/connection/dbconnection.php';

if (isset($_POST["login_button"])) {

    function redirectToLocation($location = "adminukt", $message = null)
    {
        if (!in_array($location, ['adminukt', 'content_manager'])) {
            echo "Invalid location.";
            exit;
        }

        $url = "../../../pages/$location/login.php";
        if ($message !== null) {
            $url .= "?message=" . urlencode($message);
        }


        // echo $url;
        header("Location: $url");
        exit;
    }

    $conn->begin_transaction();
    try {


        $login_value = $_POST["email"];
        $password = $_POST["password"];

        $stmt = $conn->prepare("SELECT * FROM user_account WHERE (email = ? OR username = ?) AND `password` = ?");
        $stmt->bind_param("sss", $login_value, $login_value, $password);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $location = $row['user_type'] == "Administrator" ? 'adminukt' : 'content_manager';
            $user_type = $location == "adminukt" ? 'Administrator' : 'Content Manager';


            $userId = $row['user_id'];

            // Generate and save session token
            session_regenerate_id();
            $session_token = session_id();

            $stmt2 = $conn->prepare("UPDATE user_account SET session_token = ? WHERE user_id = ?");
            $stmt2->bind_param("ss", $session_token, $userId);
            if (!$stmt2->execute()) {
                $conn->rollback();
                redirectToLocation(
                    "adminukt",
                    "Session Token Failed."
                );
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
                redirectToLocation(
                    "adminukt",
                    "Log in trail Failed to save."
                );
            }

            // Set Remember Me cookie (valid for 30 days)
            if (isset($_POST['remember'])) {
                setcookie("remember_me", $session_token, time() + (30 * 24 * 60 * 60), "/");
            } else {
                setcookie("remember_me", "", time() - 3600, "/");
            }

            $conn->commit();
            redirectToLocation(
                $location
            );
        } else {
            redirectToLocation("adminukt", "Password Not Matched.");
        }
    } catch (Exception $e) {
        $conn->rollback();
        redirectToLocation("adminukt", "Something Went Wrong. Please try again.");
    }
}

//if mag clear lang to
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

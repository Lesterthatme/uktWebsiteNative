<?php

session_start();
require $_SERVER['DOCUMENT_ROOT'] . '/ukt' . '/connection/dbconnection.php';

if (isset($_POST['editProfileBtn'])) {
    $conn->begin_transaction();
    try {
        $firstname = $_POST['ap_firstname'];
        $mi = $_POST['ap_mi'];
        $lastname = $_POST['ap_lastname'];
        $birthday = $_POST['birthday'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $sex = $_POST['sex'];
        $user_id = $_SESSION['user_id'];

        // Check if user exists
        $fetch_query = "SELECT username FROM user_account WHERE user_id = ?";
        $stmt = $conn->prepare($fetch_query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $current_user = $result->fetch_assoc();

        if (!$current_user) {
            $_SESSION['toastMsg'] = "User not found.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: /ukt/pages/adminukt/edit_profile.php");
            exit;
        }

        // Handle profile image upload
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $image_tmp_name = $_FILES['profile_image']['tmp_name'];
            $image_name = time() . "_" . $_FILES['profile_image']['name']; // Prevent duplicate names
            $upload_dir = '../../assets/uploads/profile_pic/';
            $image_path = $upload_dir . basename($image_name);

            if (move_uploaded_file($image_tmp_name, $image_path)) {

                $update_image_query = "UPDATE user_account SET image = ? WHERE user_id = ?";
                $stmt = $conn->prepare($update_image_query);
                $stmt->bind_param('si', $image_name, $user_id);
                if (! $stmt->execute()) {
                    $conn->rollback();
                    $_SESSION['toastMsg'] = "Something went wrong in user account.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: /ukt/pages/adminukt/edit_profile.php");
                    exit;
                }
            }
        }

        // Update authorized_person table
        $query = "UPDATE authorized_person SET ap_firstname = ?, ap_mi = ?, ap_lastname = ?, birthday = ?, sex = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssi', $firstname, $mi, $lastname, $birthday, $sex, $user_id);
        if (! $stmt->execute()) {
            $conn->rollback();
            $_SESSION['toastMsg'] = "Something went wrong in authorized person db.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: /ukt/pages/adminukt/edit_profile.php");
            exit;
        }

        // Update user_account table
        $query = "UPDATE user_account SET email = ?, username = ? WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $email, $username, $user_id);
        if (! $stmt->execute()) {
            $conn->rollback();
            $_SESSION['toastMsg'] = "Something went wrong in user account db.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: /ukt/pages/adminukt/edit_profile.php");
            exit;
        }

        // Log the action
        $description = "Admin Profile Updated.";
        $log_date = date('Y-m-d');
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param('sssi', $description, $log_date, $log_time, $user_id);
        if (!$log_stmt->execute()) {
            $conn->rollback();
            $_SESSION['toastMsg'] = "Something went wrong in log.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: /ukt/pages/adminukt/edit_profile.php");
            exit;
        }

        // Set session message for toast alert
        $conn->commit();
        $_SESSION['toastMsg'] = "Profile updated successfully!";
        $_SESSION['toastType'] = "toast-success";
        header("Location: /ukt/pages/adminukt/edit_profile.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['toastMsg'] = "Something Went Wrong.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: /ukt/pages/adminukt/edit_profile.php");
        exit;
    }
}

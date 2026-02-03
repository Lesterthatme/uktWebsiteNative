<?php
session_start(); 
include '../../../connection/dbconnection.php';
date_default_timezone_set('Asia/Phnom_Penh');

// FUNCTION ON ADDING LIBRARY STAFF START
if (isset($_POST['add_librarystaff'])) {
    session_start();
    $status = $_POST['status'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;
    $image = $_FILES['staff_image'] ?? null;
    $library_id = 1; 

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in! Session user_id is missing.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../library_staff");
        exit();
    }

    if ($status) {
        $image_path = null;
        if ($image && $image['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            if (in_array($image['type'], $allowed_types)) {
                $upload_dir = '../assets/uploads/librarystaff_images/';
                $image_name = uniqid() . "_" . basename($image['name']);
                $image_path = $image_name;

                if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
                    $_SESSION['toastMsg'] = "Upload folder missing or not writable! Check folder permissions.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../library_staff");
                    exit();
                }

                if (!move_uploaded_file($image['tmp_name'], $upload_dir . $image_name)) {
                    $_SESSION['toastMsg'] = "Failed to upload image! Check file permissions or path.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../library_staff");
                    exit();
                }
            } else {
                $_SESSION['toastMsg'] = "Invalid image format! Allowed types: JPEG, JPG, PNG.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../library_staff");
                exit();
            }
        }

        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = $user_id";
        $ap_result = $conn->query($ap_query);
        if ($ap_result->num_rows > 0) {
            $ap_row = $ap_result->fetch_assoc();
            $ap_id = $ap_row['ap_id'];
        } else {
            $_SESSION['toastMsg'] = "No authorized person found for this user_id ($user_id)!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../library_staff");
            exit();
        }

        $query = "INSERT INTO library_staff (staff_firstname, staff_middlename, staff_lastname, staff_position, staff_email, staff_contactnumber, status, library_id, ap_id, staff_image) 
                  VALUES ('{$_POST['staff_firstname']}', '{$_POST['staff_middlename']}', '{$_POST['staff_lastname']}', '{$_POST['staff_position']}', '{$_POST['staff_email']}', '{$_POST['staff_contactnumber']}', '$status', '$library_id', '$ap_id', '$image_path')";

        if ($conn->query($query) === TRUE) {
            $log_description = "Added a new Library Staff: {$_POST['staff_firstname']} {$_POST['staff_lastname']}";
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";
            if ($conn->query($log_query) === TRUE) {
                $_SESSION['toastMsg'] = "Library Staff added and logged successfully!";
                $_SESSION['toastType'] = "toast-success";
            } else {
                $_SESSION['toastMsg'] = "Error logging the action.";
                $_SESSION['toastType'] = "toast-error";
            }
        } else {
            $_SESSION['toastMsg'] = "Error adding library staff: " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "All fields are required!";
        $_SESSION['toastType'] = "toast-error";
    }

    $conn->close();
    header("Location: ../library_staff");
    exit();
}
// FUNCTION ON ADDING LIBRARY STAFF END

// UPDATE LIBRARY STAFF START
if (isset($_POST['update_librarystaff'])) {
    session_start();
    $staff_id = $_POST['staff_id'];
    $staff_firstname = $_POST['staff_firstname'];
    $staff_middlename = $_POST['staff_middlename'];
    $staff_lastname = $_POST['staff_lastname'];
    $staff_position = $_POST['staff_position'];
    $staff_contactnumber = $_POST['staff_contactnumber'];
    $staff_email = $_POST['staff_email'];
    $status = $_POST['status'];
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../library_staff");
        exit();
    }

    $image_path = null;

    if (!empty($_FILES['staff_image']['name'])) {
        $target_dir = "../assets/uploads/library_staff_images/";
        $image_name = uniqid() . "_" . basename($_FILES["staff_image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["staff_image"]["tmp_name"], $target_file)) {
            $image_path = $image_name;
        } else {
            $_SESSION['toastMsg'] = "Error uploading image!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../library_staff");
            exit();
        }
    }

    if ($image_path) {
        $sql = "UPDATE library_staff SET staff_firstname = ?, staff_middlename = ?, staff_lastname = ?, 
                    staff_position = ?, staff_contactnumber = ?, staff_email = ?, status = ?, staff_image = ? 
                WHERE staff_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $staff_firstname, $staff_middlename, $staff_lastname, $staff_position, 
            $staff_contactnumber, $staff_email, $status, $image_path, $staff_id);
    } else {
        $sql = "UPDATE library_staff SET staff_firstname = ?, staff_middlename = ?, staff_lastname = ?, 
                    staff_position = ?, staff_contactnumber = ?, staff_email = ?, status = ? WHERE staff_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $staff_firstname, $staff_middlename, $staff_lastname, $staff_position, 
            $staff_contactnumber, $staff_email, $status, $staff_id);
    }

    if ($stmt->execute()) {
        $log_description = "Updated Library Staff: $staff_firstname $staff_lastname";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES (?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);

        if ($log_stmt->execute()) {
            $_SESSION['toastMsg'] = "Library Staff updated successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error logging the action.";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Error updating Library Staff: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $conn->close();
    header("Location: ../library_staff");
    exit();
}
// UPDATE LIBRARY STAFF END

// Delete director function start
if (isset($_GET['delete_id'])) {
    $staff_id = $_GET['delete_id'];
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }

    // Fetch director details before deletion
    $query = "SELECT staff_firstname, staff_lastname FROM library_staff WHERE staff_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i",  $staff_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $last_name);
    $stmt->fetch();
    $stmt->close();

    if (!$first_name) {
        $_SESSION['toastMsg'] = "Library Staff not found!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../library_staff");
        exit();
    }

    // Log deletion in history_log
    $log_description = "Deleted Library staff: $first_name $last_name";
    $log_date = date("Y-m-d");
    $log_time = date("H:i:s");

    $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
    $log_stmt = $conn->prepare($log_query);
    $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
    $log_stmt->execute();
    $log_stmt->close();

    // Delete the Library Staff
    $delete_query = "DELETE FROM library_staff WHERE staff_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $staff_id);

    if ($delete_stmt->execute()) {
        $_SESSION['toastMsg'] = "Library Staff deleted successfully and logged.";
        $_SESSION['toastType'] = "toast-success";
        header("Location: ../library_staff");
    } else {
        $_SESSION['toastMsg'] = "Error deleting Library Staff.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../library_staff");
    }

    $delete_stmt->close();
    $conn->close();
}
// Delete director function end

?>
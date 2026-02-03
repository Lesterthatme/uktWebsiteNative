<?php
include '../connection/dbconnection.php';
session_start();
date_default_timezone_set('Asia/Phnom_Penh');

// add comlab image start
if (isset($_POST['add_comlab_images'])) {
    $user_id = $_SESSION['user_id'];

    // Get ap_id of current user
    $ap_result = mysqli_query($conn, "SELECT ap_id FROM authorized_person WHERE user_id = $user_id");
    $ap_data = mysqli_fetch_assoc($ap_result);
    $ap_id = $ap_data['ap_id'] ?? null;

    if (!$ap_id) {
        $_SESSION['toastMsg'] = "Authorized person not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/computer_laboratory");
        exit();
    }

    // Get lab_id
    $lab_result = mysqli_query($conn, "SELECT lab_id FROM computer_laboratory WHERE up_id = 1");
    $lab_data = mysqli_fetch_assoc($lab_result);
    $lab_id = $lab_data['lab_id'] ?? null;

    if (!$lab_id) {
        $_SESSION['toastMsg'] = "Computer Laboratory not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/computer_laboratory");
        exit();
    }

    $imageCount = count($_FILES['comlab_images']['name']);
    for ($i = 0; $i < $imageCount; $i++) {
        $imageName = $_FILES['comlab_images']['name'][$i];
        $imageTmp = $_FILES['comlab_images']['tmp_name'][$i];
        $imageError = $_FILES['comlab_images']['error'][$i];
        $imageSize = $_FILES['comlab_images']['size'][$i];

        if ($imageError === 0 && $imageSize < 5 * 1024 * 1024) {
            $ext = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif'];
            if (in_array($ext, $allowed)) {
                $newName = uniqid("comlab_", true) . "." . $ext;
                $destination = "../assets/uploads/computer laboratory/" . $newName;

                if (move_uploaded_file($imageTmp, $destination)) {
                    $insert = "INSERT INTO computer_laboratory_image (comlab_image, lab_id) VALUES ('$newName', $lab_id)";
                    mysqli_query($conn, $insert);
                }
            }
        }
    }

    // History Log
    $description = "Added new Computer Laboratory image(s).";
    $log_date = date('Y-m-d');
    $log_time = date('H:i:s');
    mysqli_query($conn, "INSERT INTO history_log (description, log_date, log_time, user_id)
                         VALUES ('$description', '$log_date', '$log_time', $user_id)");

    $_SESSION['toastMsg'] = "Images uploaded successfully!";
    $_SESSION['toastType'] = "toast-success";
    header("Location: ../pages/adminukt/computer_laboratory");
    exit();
}
// add comlab image end

// Update Computer Lab Description start
if (isset($_POST['update_comlab'])) {
    $description = mysqli_real_escape_string($conn, $_POST['comlab_description']);
    $user_id = $_SESSION['user_id'];

    // Update query
    $updateQuery = "UPDATE computer_laboratory SET comlab_description = '$description' WHERE up_id = 1";

    if (mysqli_query($conn, $updateQuery)) {
        // Log the update
        $log_description = "Updated Computer Laboratory Description.";
        $log_date = date('Y-m-d');
        $log_time = date('H:i:s');

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id)
                     VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $logQuery);

        $_SESSION['toastMsg'] = "Computer Lab description updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating description: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/computer_laboratory");
    exit();
}
// Update Computer Lab Description end

// delete comlab image start 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comlab_image'])) {
    $image_name = mysqli_real_escape_string($conn, $_POST['comlab_image']);
    $user_id = $_SESSION['user_id'];

    $image_path = "../../assets/uploads/computer laboratory/" . $image_name;

    // Delete image from database using image name
    $deleteQuery = "DELETE FROM computer_laboratory_image WHERE comlab_image = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, "s", $image_name);

    if (mysqli_stmt_execute($stmt)) {
        // Delete the file
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Log to history_log
        $description = "Deleted a computer laboratory image: " . $image_name;
        $log_date = date('Y-m-d');
        $log_time = date('H:i:s');
        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id)
                     VALUES (?, ?, ?, ?)";
        $logStmt = mysqli_prepare($conn, $logQuery);
        mysqli_stmt_bind_param($logStmt, "sssi", $description, $log_date, $log_time, $user_id);
        mysqli_stmt_execute($logStmt);

        $_SESSION['toastMsg'] = "Image deleted successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error deleting image.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/computer_laboratory");
    exit();
}
// delete comlab image end

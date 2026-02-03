<?php
session_start(); 
include '../connection/dbconnection.php';
date_default_timezone_set('Asia/Phnom_Penh');

// START >> ADD RECTOR FUNCTION
if (isset($_POST['add_rector'])) {
    $status = 'Active';
    $user_id = $_SESSION['user_id'] ?? null;
    $image = $_FILES['image'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in! Session user_id is missing.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/rector_page");
        exit();
    }

    if ($user_id) {
        $image_path = null;
        if ($image && $image['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            if (in_array($image['type'], $allowed_types)) {
                $upload_dir = '../assets/uploads/rector_image/';
                $image_name = uniqid() . "_" . basename($image['name']);
                $image_path = $image_name;

                if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
                    $_SESSION['toastMsg'] = "Upload folder missing or not writable! Check folder permissions.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../pages/adminukt/rector_page");
                    exit();
                }

                if (!move_uploaded_file($image['tmp_name'], $upload_dir . $image_name)) {
                    $_SESSION['toastMsg'] = "Failed to upload image! Check file permissions or path.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../pages/adminukt/rector_page");
                    exit();
                }
            } else {
                $_SESSION['toastMsg'] = "Invalid image format! Allowed types: JPEG, JPG, PNG.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/rector_page");
                exit();
            }
        } else if ($image['error'] != 4) { 
            $_SESSION['toastMsg'] = "Error uploading image! Error code: " . $image['error'];
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/rector_page");
            exit();
        }

        // Fetch the authorized person ID for the logged-in user
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = '$user_id'";
        $ap_result = mysqli_query($conn, $ap_query);

        if (!$ap_result || mysqli_num_rows(result: $ap_result) == 0) {
            $_SESSION['toastMsg'] = "No authorized person found for this user_id ($user_id)!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/rector_page");
            exit();
        }

        $ap_row = mysqli_fetch_assoc($ap_result);
        $ap_id = $ap_row['ap_id'];

        // Escape input data for security
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $rector_details = mysqli_real_escape_string($conn, $_POST['rector_details']);
        $status = mysqli_real_escape_string($conn, $status);
        $image_path = mysqli_real_escape_string($conn, $image_path);

        // Insert into rector table
        $query = "INSERT INTO rector (first_name, middle_name, last_name, date_appointed, rector_details, status, ap_id, image) 
                  VALUES ('$first_name', '$middle_name', '$last_name', CURDATE(), '$rector_details', '$status', '$ap_id', '$image_path')";

        if (mysqli_query($conn, $query)) {
            // Log the action
            $log_description = "Added a new Rector: " . $first_name . " " . $last_name;
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                          VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";

            if (mysqli_query($conn, $log_query)) {
                $_SESSION['toastMsg'] = "Rector added and logged successfully!";
                $_SESSION['toastType'] = "toast-success";
            } else {
                $_SESSION['toastMsg'] = "Error logging the action: " . mysqli_error($conn);
                $_SESSION['toastType'] = "toast-error";
            }
        } else {
            $_SESSION['toastMsg'] = "Error adding rector: " . mysqli_error($conn);
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "All fields are required!";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/rector_page");
    exit();
}
// END >> ADD RECTOR FUNCTION

// START >> EDIT RECTOR FUNCTION
if (isset($_POST['update_rector'])) {

    $rector_id = $_POST['rector_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $date_appointed = $_POST['date_appointed'];
    $status = $_POST['status'];
    $user_id = $_SESSION['user_id'] ?? null;
    $rector_details = $_POST['rector_details'];

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/rector_page");
        exit();
    }

    // Fetch current rector data before updating
    $fetch_query = "SELECT first_name, middle_name, last_name, date_appointed, status, image, rector_details 
                    FROM rector WHERE rector_id = ?";
    $fetch_stmt = $conn->prepare($fetch_query);
    if (!$fetch_stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing fetch query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/rector_page");
        exit();
    }
    $fetch_stmt->bind_param("i", $rector_id);
    $fetch_stmt->execute();
    $fetch_stmt->bind_result($old_first_name, $old_middle_name, $old_last_name, $old_date_appointed, $old_status, $old_image, $old_rector_details);
    $fetch_stmt->fetch();
    $fetch_stmt->close();

    // Check if an image is uploaded
    $image_path = $old_image;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../assets/uploads/rector_image/";
        $image_name = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $image_name;
        } else {
            $_SESSION['toastMsg'] = "Error uploading image!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/rector_page");
            exit();
        }
    }

    // Detect changes
    $changes = [];
    if ($first_name !== $old_first_name) $changes[] = "First Name changed from '$old_first_name' to '$first_name'";
    if ($middle_name !== $old_middle_name) $changes[] = "Middle Name changed from '$old_middle_name' to '$middle_name'";
    if ($last_name !== $old_last_name) $changes[] = "Last Name changed from '$old_last_name' to '$last_name'";
    if ($date_appointed !== $old_date_appointed) $changes[] = "Date Appointed changed from '$old_date_appointed' to '$date_appointed'";
    if ($status !== $old_status) $changes[] = "Status changed from '$old_status' to '$status'";
    if ($image_path !== $old_image) $changes[] = "Profile Image updated";
    if ($rector_details !== $old_rector_details) $changes[] = "Rector Details updated";

    if (empty($changes)) {
        $_SESSION['toastMsg'] = "No changes detected.";
        $_SESSION['toastType'] = "toast-warning";
        header("Location: ../pages/adminukt/rector_page");
        exit();
    }

    // Update query
    $update_query = "UPDATE rector SET 
                    first_name=?, middle_name=?, last_name=?, 
                    date_appointed=?, status=?, image=?, rector_details=? 
                    WHERE rector_id=?";
    $stmt = $conn->prepare($update_query);
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing update query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/rector_page");
        exit();
    }
    $stmt->bind_param("sssssssi", $first_name, $middle_name, $last_name, $date_appointed, $status, $image_path, $rector_details, $rector_id);

    if ($stmt->execute()) {
        // Log changes
        $log_description = "Updated Rector: $first_name $last_name. Changes: " . implode(", ", $changes);
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES (?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        if ($log_stmt) {
            $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
            $log_stmt->execute();
            $log_stmt->close();
        }

        $_SESSION['toastMsg'] = "Rector updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating rector!";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();

    // Redirect to the Rectors page
    header("Location: ../pages/adminukt/rector_page");
    exit();
}
// END >> EDIT RECTOR FUNCTION

// DELETE RECTOR FUNCTION START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_rector']) && isset($_POST['rector_id'])) {
    $rector_id = intval($_POST['rector_id']); 
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/rector_page");
        exit();
    }

    // Fetch rector details
    $query = "SELECT first_name, middle_name, last_name, image FROM rector WHERE rector_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $rector_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $middle_name, $last_name, $image);
    $stmt->fetch();
    $stmt->close();

    if (!$first_name) {
        $_SESSION['toastMsg'] = "Rector not found!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/rector_page");
        exit();
    }

    $full_name = trim("$first_name $middle_name $last_name");

    // Delete rector from database
    $delete_query = "DELETE FROM rector WHERE rector_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $rector_id);

    if ($stmt->execute()) {
        // Delete associated image
        $image_path = "../../assets/uploads/rectors/" . $image;
        if (!empty($image) && file_exists($image_path)) {
            unlink($image_path);
        }

        // Log the deletion
        $log_description = "Deleted rector: '$full_name'";
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES (?, CURDATE(), CURTIME(), ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("si", $log_description, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "Rector deleted successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete the rector!";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../pages/adminukt/rector_page");
    exit();
}
// DELETE RECTOR FUNCTION END

?>
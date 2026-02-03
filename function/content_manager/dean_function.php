<?php
session_start();
include '../../connection/dbconnection.php';
date_default_timezone_set('Asia/Phnom_Penh');

// START >> ADD DEAN FUNCTION
if (isset($_POST['add_dean'])) {
    $status = 'Active';
    $user_id = $_SESSION['user_id'] ?? null;
    $image = $_FILES['image'] ?? null;
    $department_id = $_POST['department_id'] ?? null;
    $date_appointed = $_POST['date_appointed'] ?? null; // Get date from input field

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in! Session user_id is missing.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/dean_page");
        exit();
    }

    if ($user_id && $department_id && $date_appointed) {
        $image_path = null;
        if ($image && $image['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            if (in_array($image['type'], $allowed_types)) {
                $upload_dir = '../../assets/uploads/dean_image/';
                $image_name = uniqid() . "_" . basename($image['name']);
                $image_path = $image_name;

                if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
                    $_SESSION['toastMsg'] = "Upload folder missing or not writable! Check folder permissions.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../../pages/content_manager/dean_page");
                    exit();
                }

                if (!move_uploaded_file($image['tmp_name'], $upload_dir . $image_name)) {
                    $_SESSION['toastMsg'] = "Failed to upload image! Check file permissions or path.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../../pages/content_manager/dean_page");
                    exit();
                }
            } else {
                $_SESSION['toastMsg'] = "Invalid image format! Allowed types: JPEG, JPG, PNG.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../../pages/content_manager/dean_page");
                exit();
            }
        } else if ($image['error'] != 4) {
            $_SESSION['toastMsg'] = "Error uploading image! Error code: " . $image['error'];
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/dean_page");
            exit();
        }

        // Fetch the authorized person ID for the logged-in user
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = '$user_id'";
        $ap_result = mysqli_query($conn, $ap_query);

        if (!$ap_result || mysqli_num_rows($ap_result) == 0) {
            $_SESSION['toastMsg'] = "No authorized person found for this user_id ($user_id)!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/dean_page");
            exit();
        }

        $ap_row = mysqli_fetch_assoc($ap_result);
        $ap_id = $ap_row['ap_id'];

        // Escape input data for security
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $status = mysqli_real_escape_string($conn, $status);
        $image_path = mysqli_real_escape_string($conn, $image_path);
        $department_id = mysqli_real_escape_string($conn, $department_id);
        $date_appointed = mysqli_real_escape_string($conn, $date_appointed);

        // Insert into university_dean table including department_id
        $query = "INSERT INTO university_dean (first_name, middle_name, last_name, date_appointed, status, ap_id, image, department_id) 
                  VALUES ('$first_name', '$middle_name', '$last_name', '$date_appointed', '$status', '$ap_id', '$image_path', '$department_id')";

        if (mysqli_query($conn, $query)) {
            // Log the action
            $log_description = "Added a new University Dean: " . $first_name . " " . $last_name;
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                          VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";

            if (mysqli_query($conn, $log_query)) {
                $_SESSION['toastMsg'] = "Dean added and logged successfully!";
                $_SESSION['toastType'] = "toast-success";
            } else {
                $_SESSION['toastMsg'] = "Error logging the action: " . mysqli_error($conn);
                $_SESSION['toastType'] = "toast-error";
            }
        } else {
            $_SESSION['toastMsg'] = "Error adding dean: " . mysqli_error($conn);
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "All fields are required!";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../../pages/content_manager/dean_page");
    exit();
}

// END >> ADD DEAN FUNCTION

// START >> EDIT DEAN FUNCTION
if (isset($_POST['update_dean'])) {

    $dean_id = $_POST['dean_id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $date_appointed = $_POST['date_appointed'];
    $status = $_POST['status'];
    $department_id = $_POST['department_id']; // Retrieve department ID
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/dean_page");
        exit();
    }

    // Fetch current dean data before updating
    $fetch_query = "SELECT first_name, middle_name, last_name, date_appointed, status, image, department_id 
                    FROM university_dean WHERE dean_id = ?";
    $fetch_stmt = $conn->prepare($fetch_query);
    if (!$fetch_stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing fetch query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/dean_page");
        exit();
    }
    $fetch_stmt->bind_param("i", $dean_id);
    $fetch_stmt->execute();
    $fetch_stmt->bind_result($old_first_name, $old_middle_name, $old_last_name, $old_date_appointed, $old_status, $old_image, $old_department_id);
    $fetch_stmt->fetch();
    $fetch_stmt->close();

    // Check if an image is uploaded
    $image_path = $old_image;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../assets/uploads/dean_image/";
        $image_name = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $image_name;
        } else {
            $_SESSION['toastMsg'] = "Error uploading image!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/dean_page");
            exit();
        }
    }

    // Detect changes
    $changes = [];
    if ($first_name !== $old_first_name)
        $changes[] = "First Name changed from '$old_first_name' to '$first_name'";
    if ($middle_name !== $old_middle_name)
        $changes[] = "Middle Name changed from '$old_middle_name' to '$middle_name'";
    if ($last_name !== $old_last_name)
        $changes[] = "Last Name changed from '$old_last_name' to '$last_name'";
    if ($date_appointed !== $old_date_appointed)
        $changes[] = "Date Appointed changed from '$old_date_appointed' to '$date_appointed'";
    if ($status !== $old_status)
        $changes[] = "Status changed from '$old_status' to '$status'";
    if ($image_path !== $old_image)
        $changes[] = "Profile Image updated";
    if ($department_id != $old_department_id)
        $changes[] = "Department changed from '$old_department_id' to '$department_id'";

    if (empty($changes)) {
        $_SESSION['toastMsg'] = "No changes detected.";
        $_SESSION['toastType'] = "toast-warning";
        header("Location: ../../pages/content_manager/dean_page");
        exit();
    }

    // Update dean details including department_id
    $update_query = "UPDATE university_dean 
                     SET first_name=?, middle_name=?, last_name=?, date_appointed=?, status=?, image=?, department_id=? 
                     WHERE dean_id=?";
    $stmt = $conn->prepare($update_query);
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing update query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/dean_page");
        exit();
    }
    $stmt->bind_param("ssssssii", $first_name, $middle_name, $last_name, $date_appointed, $status, $image_path, $department_id, $dean_id);

    if ($stmt->execute()) {
        // Log changes
        $log_description = "Dean Information Updated ";
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

        $_SESSION['toastMsg'] = "Dean updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating dean!";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();

    // Redirect to the Dean page
    header("Location: ../../pages/content_manager/dean_page");
    exit();
}

// END >> EDIT DEAN FUNCTION

// DELETE DEAN FUNCTION START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_dean']) && isset($_POST['dean_id'])) {
    include '../connection/dbconnection.php';
    session_start();
    
    $dean_id = intval($_POST['dean_id']);
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/dean_page");
        exit();
    }

    // Fetch dean details
    $query = "SELECT first_name, middle_name, last_name, image FROM university_dean WHERE dean_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $dean_id);
    $stmt->execute();
    $stmt->bind_result($first_name, $middle_name, $last_name, $image);
    $stmt->fetch();
    $stmt->close();

    if (!$first_name) {
        $_SESSION['toastMsg'] = "Dean not found!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/dean_page");
        exit();
    }

    $full_name = trim("$first_name $middle_name $last_name");

    // **Set department_id to NULL before deleting dean**
    $clear_department_query = "UPDATE department SET ap_id = NULL WHERE ap_id IN (SELECT ap_id FROM university_dean WHERE dean_id = ?)";
    $clear_stmt = $conn->prepare($clear_department_query);
    $clear_stmt->bind_param("i", $dean_id);
    $clear_stmt->execute();
    $clear_stmt->close();

    // Delete dean
    $delete_query = "DELETE FROM university_dean WHERE dean_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $dean_id);

    if ($stmt->execute()) {
        // Delete associated image
        $image_path = "../../assets/uploads/dean_image/" . $image;
        if (!empty($image) && file_exists($image_path)) {
            unlink($image_path);
        }

        // Log the deletion
        $log_description = "Deleted Dean: '$full_name'";
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES (?, CURDATE(), CURTIME(), ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("si", $log_description, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "Dean deleted successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete the dean!";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../pages/content_manager/dean_page");
    exit();
}

// DELETE DEAN FUNCTION END
?>
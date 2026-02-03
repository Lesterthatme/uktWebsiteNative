<?php
session_start(); 
include '../../connection/dbconnection.php';
date_default_timezone_set('Asia/Phnom_Penh');

// START >> ADD founder FUNCTION
if (isset($_POST['add_founder'])) {
    $user_id = $_SESSION['user_id'] ?? null;
    $image = $_FILES['image'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in! Session user_id is missing.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/university_founder");
        exit();
    }

    if ($user_id) {
        $image_path = null;
        if ($image && $image['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            if (in_array($image['type'], $allowed_types)) {
                $upload_dir = '../../assets/uploads/founder_image/';
                $image_name = uniqid() . "_" . basename($image['name']);
                $image_path = $image_name;

                if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
                    $_SESSION['toastMsg'] = "Upload folder missing or not writable! Check folder permissions.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../../pages/content_manager/university_founder");
                    exit();
                }

                if (!move_uploaded_file($image['tmp_name'], $upload_dir . $image_name)) {
                    $_SESSION['toastMsg'] = "Failed to upload image! Check file permissions or path.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../../pages/content_manager/university_founder");
                    exit();
                }
            } else {
                $_SESSION['toastMsg'] = "Invalid image format! Allowed types: JPEG, JPG, PNG.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../../pages/content_manager/university_founder");
                exit();
            }
        } else if ($image['error'] != 4) { 
            $_SESSION['toastMsg'] = "Error uploading image! Error code: " . $image['error'];
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/university_founder");
            exit();
        }

        // Fetch the authorized person ID for the logged-in user
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = '$user_id'";
        $ap_result = mysqli_query($conn, $ap_query);

        if (!$ap_result || mysqli_num_rows(result: $ap_result) == 0) {
            $_SESSION['toastMsg'] = "No authorized person found for this user_id ($user_id)!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/university_founder");
            exit();
        }

        $ap_row = mysqli_fetch_assoc($ap_result);
        $ap_id = $ap_row['ap_id'];

        // Escape input data for security
        $founder_fname = mysqli_real_escape_string($conn, $_POST['founder_fname']);
        $founder_mname = mysqli_real_escape_string($conn, $_POST['founder_mname']);
        $founder_lname = mysqli_real_escape_string($conn, $_POST['founder_lname']);
        $founder_description = mysqli_real_escape_string($conn, $_POST['founder_description']);
        $date_founded = mysqli_real_escape_string($conn, $_POST['date_founded']);
        $image_path = mysqli_real_escape_string($conn, $image_path);

        // Insert into university founder table
        $query = "INSERT INTO university_founder (founder_fname, founder_mname, founder_lname, founder_description, date_founded, ap_id, up_id, image) 
        VALUES ('$founder_fname', '$founder_mname', '$founder_lname', '$founder_description', '$date_founded', '$ap_id', 1, '$image_path')";

        if (mysqli_query($conn, $query)) {
            // Log the action
            $log_description = "Added a new University Founder: " . $founder_fname . " " . $founder_lname;
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                          VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";

            if (mysqli_query($conn, $log_query)) {
                $_SESSION['toastMsg'] = "University Founder added and logged successfully!";
                $_SESSION['toastType'] = "toast-success";
            } else {
                $_SESSION['toastMsg'] = "Error logging the action: " . mysqli_error($conn);
                $_SESSION['toastType'] = "toast-error";
            }
        } else {
            $_SESSION['toastMsg'] = "Error adding University Founder: " . mysqli_error($conn);
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "All fields are required!";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../../pages/content_manager/university_founder");
    exit();
}
// END >> ADD founder FUNCTION

// START >> EDIT founder FUNCTION
if (isset($_POST['update_founder'])) {

    $founder_id = $_POST['founder_id'];
    $founder_fname = $_POST['founder_fname'];
    $founder_mname = $_POST['founder_mname'];
    $founder_lname = $_POST['founder_lname'];
    $date_founded = $_POST['date_founded'];
    $user_id = $_SESSION['user_id'] ?? null;
    $founder_description = $_POST['founder_description'];

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/university_founder");
        exit();
    }

    // Fetch current university_founder data before updating
    $fetch_query = "SELECT founder_fname, founder_mname, founder_lname, date_founded, image, founder_description 
                    FROM university_founder WHERE founder_id = ?";
    $fetch_stmt = $conn->prepare($fetch_query);
    if (!$fetch_stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing fetch query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/university_founder");
        exit();
    }
    $fetch_stmt->bind_param("i", $founder_id);
    $fetch_stmt->execute();
    $fetch_stmt->bind_result($old_founder_fname, $old_founder_mname, $old_founder_lname, $old_date_founded, $old_image, $old_founder_description);
    $fetch_stmt->fetch();
    $fetch_stmt->close();

    // Check if an image is uploaded
    $image_path = $old_image;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../../assets/uploads/founder_image/";
        $image_name = uniqid() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $image_name;
        } else {
            $_SESSION['toastMsg'] = "Error uploading image!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/university_founder");
            exit();
        }
    }

    // Detect changes
    $changes = [];
    if ($founder_fname !== $old_founder_fname) $changes[] = "First Name changed from '$old_founder_fname' to '$founder_fname'";
    if ($founder_mname !== $old_founder_mname) $changes[] = "Middle Name changed from '$old_founder_mname' to '$founder_mname'";
    if ($founder_lname !== $old_founder_lname) $changes[] = "Last Name changed from '$old_founder_lname' to '$founder_lname'";
    if ($date_founded !== $old_date_founded) $changes[] = "Date Founded changed from '$old_date_founded' to '$date_founded'";
    if ($image_path !== $old_image) $changes[] = "Profile Image updated";
    if ($founder_description !== $old_founder_description) $changes[] = "Founder Details updated";

    if (empty($changes)) {
        $_SESSION['toastMsg'] = "No changes detected.";
        $_SESSION['toastType'] = "toast-warning";
        header("Location: ../../pages/content_manager/university_founder");
        exit();
    }

    // Update query
    $update_query = "UPDATE university_founder SET 
                    founder_fname=?, founder_mname=?, founder_lname=?, 
                    date_founded=?, image=?, founder_description=? 
                    WHERE founder_id=?";
    $stmt = $conn->prepare($update_query);
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing update query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/university_founder");
        exit();
    }
    $stmt->bind_param("ssssssi", $founder_fname, $founder_mname, $founder_lname, $date_founded, $image_path, $founder_description, $founder_id);

    if ($stmt->execute()) {
        // Log changes
        $log_description = "Updated Founder: $founder_fname $founder_lname. Changes: " . implode(", ", $changes);
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

        $_SESSION['toastMsg'] = "Founder updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating Founder!";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();

    // Redirect to the founder page
    header("Location: ../../pages/content_manager/university_founder");
    exit();
}
// END >> EDIT founder FUNCTION

// DELETE founder FUNCTION START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_founder']) && isset($_POST['founder_id'])) {
    $founder_id = intval($_POST['founder_id']); 
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$user_id) {
        $_SESSION['toastMsg'] = "User is not logged in!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/university_founder");
        exit();
    }

    // Fetch founder details
    $query = "SELECT founder_fname, founder_mname, founder_lname, image FROM university_founder WHERE founder_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $founder_id);
    $stmt->execute();
    $stmt->bind_result($founder_fname, $founder_mname, $founder_lname, $image);
    $stmt->fetch();
    $stmt->close();

    if (!$founder_fname) {
        $_SESSION['toastMsg'] = "Founder not found!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/university_founder");
        exit();
    }

    $full_name = trim("$founder_fname $founder_mname $founder_lname");

    // Delete founder from database
    $delete_query = "DELETE FROM university_founder WHERE founder_id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $founder_id);

    if ($stmt->execute()) {
        // Delete associated image
        $image_path = "../../assets/uploads/founder_image/" . $image;
        if (!empty($image) && file_exists($image_path)) {
            unlink($image_path);
        }

        // Log the deletion
        $log_description = "Deleted Founder: '$full_name'";
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES (?, CURDATE(), CURTIME(), ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("si", $log_description, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "Founder deleted successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete the Founder!";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../pages/content_manager/university_founder");
    exit();
}
// DELETE founder FUNCTION END

?>
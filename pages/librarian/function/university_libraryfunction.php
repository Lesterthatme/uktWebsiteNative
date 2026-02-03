<?php
include '../../../connection/dbconnection.php'; // Include your database connection file
session_start(); // Start session to get user_id

// Set the time zone to Cambodia (UTC+7)
date_default_timezone_set('Asia/Phnom_Penh');

// START >> UPDATE LIBRARY PROFILE
if (isset($_POST['update_library'])) {
    $library_id = $_POST['library_id'];
    $library_name = htmlspecialchars($_POST['library_name']);
    $library_location = htmlspecialchars($_POST['library_location']);
    $library_contact = htmlspecialchars($_POST['library_contact']);
    $library_email = htmlspecialchars($_POST['library_email']);
    $library_website = htmlspecialchars($_POST['library_website']);

    // Get the logged-in user's ID
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "User not authenticated!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../library_profile.php");
        exit();
    }
    $user_id = $_SESSION['user_id'];

    // Check if a new image is uploaded
    if (!empty($_FILES['library_logo']['name'])) {
        $target_dir = "../assets/uploads/Library_images/";
        $image_name = basename($_FILES["library_logo"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "jfif"];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["library_logo"]["tmp_name"], $target_file)) {
                // Update with new image
                $update_query = "UPDATE library_university 
                                 SET library_name = '$library_name', library_location = '$library_location', 
                                     library_contact = '$library_contact', library_email = '$library_email', 
                                     library_website = '$library_website', library_logo = '$image_name'
                                 WHERE library_id = '$library_id'";
            } else {
                $_SESSION['toastMsg'] = "Error uploading image.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../library_profile.php");
                exit();
            }
        } else {
            $_SESSION['toastMsg'] = "Error: Invalid file format. Only JPG, JPEG, PNG, and JFIF are allowed.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../library_profile.php");
            exit();
        }
    } else {
        // Update without changing the image
        $update_query = "UPDATE library_university 
                         SET library_name = '$library_name', library_location = '$library_location', 
                             library_contact = '$library_contact', library_email = '$library_email', 
                             library_website = '$library_website'
                         WHERE library_id = '$library_id'";
    }

    if ($conn->query($update_query) === TRUE) {
        // Log the update action in history_log
        $log_description = "Library details updated";
        $log_date = date('Y-m-d');
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";
        $conn->query($log_query);

        $_SESSION['toastMsg'] = "Library details updated successfully.";
        $_SESSION['toastType'] = "toast-success";
        header("Location: ../library_profile.php");
    } else {
        $_SESSION['toastMsg'] = "Update failed.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../library_profile.php");
    }

    $conn->close();
    exit();
}
// END >> UPDATE LIBRARY PROFILE

// START >> ADD IMAGE
if (isset($_POST['add_image'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Error: Session expired. Please log in again.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    if (!isset($_SESSION['ap_id'])) {
        $query = "SELECT ap_id FROM authorized_person WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $ap_id = $row['ap_id'];
            $_SESSION['ap_id'] = $ap_id;
        } else {
            $_SESSION['toastMsg'] = "Error: Authorized person not found.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../University_Library_updates.php");
            exit();
        }
    } else {
        $ap_id = $_SESSION['ap_id'];
    }

    $upload_dir = '../assets/uploads/Library_images/';
    $image_file = '';

    if (!empty($_FILES['image_file']['name'])) {
        $file_name = time() . '_' . $_FILES['image_file']['name']; 
        $file_tmp = $_FILES['image_file']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_ext = ["jpg", "jpeg", "png", "jfif"];

        if (in_array(strtolower($file_ext), $allowed_ext)) {
            move_uploaded_file($file_tmp, $upload_dir . $file_name);
            $image_file = $file_name;
        } else {
            $_SESSION['toastMsg'] = "Error: Invalid file format. Only JPG, JPEG, PNG, and JFIF allowed.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../library_profile.php");
            exit();
        }
    } else {
        $_SESSION['toastMsg'] = "Error: No image uploaded.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../library_profile.php");
        exit();
    }

    $image_name = mysqli_real_escape_string($conn, $_POST['image_name']);
    
    $sql = "INSERT INTO library_image (image_name, image_file, ap_id, library_id) 
            VALUES ('$image_name', '$image_file', '$ap_id', 1)";
    
    if (mysqli_query($conn, $sql)) {
        $log_description = "Added a new library image: $image_name";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$log_description', '$log_date', '$log_time', '$user_id')";
        
        mysqli_query($conn, $log_query);

        $_SESSION['toastMsg'] = "Library image added successfully.";
        $_SESSION['toastType'] = "toast-success";
        header("Location: ../library_profile.php");
    } else {
        $_SESSION['toastMsg'] = "Error: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../library_profile.php");
    }

    mysqli_close($conn);
    exit();
}
// END >> ADD IMAGE

// delete image start
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['imagePath'])) {
    $imagePath = $_POST['imagePath'];
    $imageFileName = basename($imagePath);

    // Start transaction
    $conn->begin_transaction();

    try {
        // Retrieve image details before deleting
        $stmt = $conn->prepare("SELECT image_id, image_name, image_file, ap_id, library_id FROM library_image WHERE image_file = ?");
        $stmt->bind_param("s", $imageFileName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image_id = $row['image_id'];
            $ap_id = $row['ap_id'];
            $library_id = $row['library_id'];

            // Prepare archive data
            $archive_description = json_encode([
                "image_id" => $image_id,
                "image_name" => $row['image_name'],
                "image_file" => $row['image_file'],
                "ap_id" => $ap_id,
                "library_id" => $library_id
            ]);
            $original_table = "library_image";
            $archived_at = date("Y-m-d H:i:s");
            $archived_by = $ap_id; // Assuming the authorized person deleting the record

            // Insert into library_archive
            $archiveStmt = $conn->prepare("INSERT INTO library_archive (original_table, record_id, archive_description, archived_at, archived_by, library_id) VALUES (?, ?, ?, ?, ?, ?)");
            $archiveStmt->bind_param("sisssi", $original_table, $image_id, $archive_description, $archived_at, $archived_by, $library_id);
            $archiveStmt->execute();
            $archiveStmt->close();

            // Delete the image from library_image
            $deleteStmt = $conn->prepare("DELETE FROM library_image WHERE image_id = ?");
            $deleteStmt->bind_param("i", $image_id);
            $deleteStmt->execute();
            $deleteStmt->close();

            // Remove the image file from server
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            // Commit transaction
            $conn->commit();

            echo "success|Library image deleted successfully!.";
        } else {
            echo "error|Image not found in the database.";
        }

        $stmt->close();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo "error|Error processing request: " . $e->getMessage();
    }

    $conn->close();
} else {
    echo "error|Invalid request.";
}
// delete image end

?>

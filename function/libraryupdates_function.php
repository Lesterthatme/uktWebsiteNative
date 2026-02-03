<?php
include '../connection/dbconnection.php';
session_start();

// Set timezone to Cambodia
date_default_timezone_set('Asia/Phnom_Penh');

if (isset($_POST['add_update'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Error: Session expired. Please log in again.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }
    $user_id = $_SESSION['user_id'];

    if (!isset($_SESSION['ap_id'])) {
        $query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($ap_id);
        $stmt->fetch();
        $stmt->close();

        if ($ap_id) {
            $_SESSION['ap_id'] = $ap_id;
        } else {
            $_SESSION['toastMsg'] = "Error: Authorized person not found.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/University_Library_updates");
            exit();
        }
    } else {
        $ap_id = $_SESSION['ap_id'];
    }

    $library_id = 1;
    $update_category = $_POST['update_category'];
    $update_title = $_POST['update_title'];
    $update_description = $_POST['update_description'];
    $posted_date = $_POST['posted_date'];

    $upload_dir = '../pages/librarian/assets/uploads/Libraryupdate_images/';
    $update_image = '';

    if (!empty($_FILES['update_image']['name'])) {
        $file_name = time() . '_' . $_FILES['update_image']['name'];
        $file_tmp = $_FILES['update_image']['tmp_name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $allowed_ext = array("jpg", "jpeg", "png", "jfif");

        if (in_array($file_ext, $allowed_ext)) {
            move_uploaded_file($file_tmp, $upload_dir . $file_name);
            $update_image = $file_name;
        } else {
            $_SESSION['toastMsg'] = "Error: Invalid file format. Only JPG, JPEG, JFIF, and PNG allowed.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/University_Library_updates");
            exit();
        }
    }

    $query = "INSERT INTO library_updates (update_image, update_category, update_title, update_description, posted_date, ap_id, library_id)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $update_image, $update_category, $update_title, $update_description, $posted_date, $ap_id, $library_id);

    if ($stmt->execute()) {
        $log_description = "Added a new library update: $update_title";
        $log_date = date("Y-m-d"); 
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "Library update added successfully.";
        $_SESSION['toastType'] = "toast-success";
        header("Location: ../pages/adminukt/University_Library_updates.php");
    } else {
        $_SESSION['toastMsg'] = "Error adding library update.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/University_Library_updates");
    }

    $stmt->close();
    $conn->close();
    exit();
}

// Check if delete_id is set
if (isset($_GET['delete_id'])) {
    $update_id = intval($_GET['delete_id']);
    $user_id = $_SESSION['user_id'];

    // Fetch the update details
    $query = "SELECT * FROM library_updates WHERE update_id = $update_id";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $update_title = $row['update_title'];
        $image_path = "../pages/librarian/assets/uploads/Libraryupdate_images/" . $row['update_image'];
        $library_id = $row['library_id'];

        // Delete the image file if it exists
        if (file_exists($image_path) && !empty($row['update_image'])) {
            unlink($image_path);
        }

        // Archive the update details
        $archive_description = mysqli_real_escape_string($conn, json_encode($row));
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = $user_id";
        $ap_result = mysqli_query($conn, $ap_query);

        if ($ap_row = mysqli_fetch_assoc($ap_result)) {
            $ap_id = $ap_row['ap_id'];

            $archive_query = "INSERT INTO library_archive (original_table, record_id, archive_description, archived_at, archived_by, library_id) VALUES ('library_updates', $update_id, '$archive_description', NOW(), $ap_id, $library_id)";
            if (mysqli_query($conn, $archive_query)) {
                // Delete the update record
                $delete_query = "DELETE FROM library_updates WHERE update_id = $update_id";
                if (mysqli_query($conn, $delete_query)) {
                    // Log the deletion
                    $log_description = mysqli_real_escape_string($conn, "Deleted a library update: $update_title");
                    $log_date = date("Y-m-d");
                    $log_time = date("H:i:s");

                    $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES ('$log_description', '$log_date', '$log_time', $user_id)";
                    mysqli_query($conn, $log_query);

                    // Set success message
                    $_SESSION['toastMsg'] = 'Deleted successfully!';
                    $_SESSION['toastType'] = "toast-success";
                } else {
                    // Set error message
                    $_SESSION['toastMsg'] = 'Error deleting the update.';
                    $_SESSION['toastType'] = "toast-danger";
                }
            } else {
                // Set error message
                $_SESSION['toastMsg'] = 'Error archiving the update.';
                $_SESSION['toastType'] = "toast-danger";
            }
        } else {
            // Set error message
            $_SESSION['toastMsg'] = 'Authorized person not found.';
            $_SESSION['toastType'] = "toast-danger";
        }
    } else {
        // Set error message
        $_SESSION['toastMsg'] = 'Library update not found.';
        $_SESSION['toastType'] = "toast-danger";
    }

    // Redirect back to the updates page
    header('Location: ../pages/adminukt/University_Library_updates');
    exit();
}



if (isset($_POST['update'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Error: Session expired. Please log in again.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../login.php");
        exit();
    }

    $update_id = $_POST['update_id'];
    $title = $_POST['update_title'];
    $description = $_POST['update_description'];
    $category = $_POST['update_category'];
    $date = $_POST['posted_date'];
    $user_id = $_SESSION['user_id']; 

    if (!empty($_FILES["update_image"]["name"])) {
        $target_dir = "../pages/librarian/assets/uploads/Libraryupdate_images/";
        $image_name = time() . "_" . basename($_FILES["update_image"]["name"]); 
        $target_file = $target_dir . $image_name;
        move_uploaded_file($_FILES["update_image"]["tmp_name"], $target_file);

        $sql = "UPDATE library_updates SET update_title=?, update_description=?, update_category=?, posted_date=?, update_image=? WHERE update_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $title, $description, $category, $date, $image_name, $update_id);
    } else {
        $sql = "UPDATE library_updates SET update_title=?, update_description=?, update_category=?, posted_date=? WHERE update_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $title, $description, $category, $date, $update_id);
    }

    if ($stmt->execute()) {
        $log_description = "Updated library update: $title";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "Update successful!";
        $_SESSION['toastType'] = "toast-success";
        header("Location: ../pages/adminukt/University_Library_updates");
    } else {
        $_SESSION['toastMsg'] = "Update failed.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/University_Library_updates");
    }

    $stmt->close();
    $conn->close();
    exit();
}

?>




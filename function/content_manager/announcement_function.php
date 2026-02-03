<?php
session_start();
include '../../connection/dbconnection.php';
date_default_timezone_set('Asia/Phnom_Penh');

// START >> ADD FUNCTION OF ANNOUNCEMENT
if (isset($_POST['add_announcement'])) {
    $announcement_title = $_POST['announcement_title'] ?? null;
    $announcement_description = $_POST['announcement_description'] ?? null;
    $announcement_status = 'active'; // <-- Force status to "Active"
    $user_id = $_SESSION['user_id'] ?? null;
    $announcement_image = $_FILES['announcement_image'] ?? null;

    if (!$announcement_title || !$announcement_description || !$user_id) { // remove checking announcement_status
        $_SESSION['toastMsg'] = "All fields are required!";
        $_SESSION['toastType'] = "toast-error";
        header("Location:  ../../pages/content_manager/announcement");
        exit();
    }

    $image_path = null;
    if ($announcement_image && $announcement_image['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        $max_file_size = 30 * 1024 * 1024; // 30MB limit

        if ($announcement_image['size'] > $max_file_size) {
            $_SESSION['toastMsg'] = "File size exceeds the 30MB limit!";
            $_SESSION['toastType'] = "toast-error";
            header("Location:  ../../pages/content_manager/announcement");
            exit();
        }

        if (in_array($announcement_image['type'], $allowed_types)) {
            $upload_dir = '../../assets/uploads/announcement/';
            $image_name = uniqid() . "_" . basename($announcement_image['name']);
            $image_path = $image_name;

            if (!move_uploaded_file($announcement_image['tmp_name'], $upload_dir . $image_name)) {
                $_SESSION['toastMsg'] = "Failed to upload image! Check file permissions.";
                $_SESSION['toastType'] = "toast-error";
                header("Location:  ../../pages/content_manager/announcement");
                exit();
            }
        } else {
            $_SESSION['toastMsg'] = "Invalid image format! Allowed types: JPEG, JPG, PNG.";
            $_SESSION['toastType'] = "toast-warning";
            header("Location:  ../../pages/content_manager/announcement");
            exit();
        }
    } elseif ($announcement_image['error'] != 4) {
        $_SESSION['toastMsg'] = "Error uploading image! Error code: " . $announcement_image['error'];
        $_SESSION['toastType'] = "toast-error";
        header("Location:  ../../pages/content_manager/announcement");
        exit();
    }

    $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
    $ap_stmt = $conn->prepare($ap_query);
    $ap_stmt->bind_param("i", $user_id);
    $ap_stmt->execute();
    $ap_stmt->bind_result($ap_id);
    $ap_stmt->fetch();
    $ap_stmt->close();

    if ($ap_id) {
        $query = "INSERT INTO announcement (announcement_title, announcement_description, announcement_date, announcement_time, announcement_image, announcement_status, ap_id) 
                  VALUES (?, ?, CURDATE(), CURRENT_TIME(), ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $announcement_title, $announcement_description, $image_path, $announcement_status, $ap_id);

        if ($stmt->execute()) {
            $log_description = "Added a new Announcement: '$announcement_title' with status '$announcement_status'";
            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                          VALUES (?, CURDATE(), CURRENT_TIME(), ?)";
            $log_stmt = $conn->prepare($log_query);
            $log_stmt->bind_param("si", $log_description, $user_id);

            if ($log_stmt->execute()) {
                $_SESSION['toastMsg'] = "Announcement added successfully!";
                $_SESSION['toastType'] = "toast-success";
            } else {
                $_SESSION['toastMsg'] = "Announcement added, but failed to log the action.";
                $_SESSION['toastType'] = "toast-warning";
            }
        } else {
            $_SESSION['toastMsg'] = "Error adding Announcement!";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "No authorized person found for the logged-in user!";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location:  ../../pages/content_manager/announcement");
    exit();
}
// END >> ADD FUNCTION OF ANNOUNCEMENT

// DELETE ANNOUNCEMENT START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && !empty($_POST['announcement_id'])) {

    $announcement_id = intval($_POST['announcement_id']);

    // Ensure user is logged in
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Unauthorized action!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/announcement");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Retrieve ap_id from authorized_person using user_id
    $ap_id = null;
    $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
    if ($ap_stmt = $conn->prepare($ap_query)) {
        $ap_stmt->bind_param("i", $user_id);
        $ap_stmt->execute();
        $ap_stmt->bind_result($ap_id);
        $ap_stmt->fetch();
        $ap_stmt->close();
    }

    if (!$ap_id) {
        $_SESSION['toastMsg'] = "Unauthorized action! No associated authorized person.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/announcement");
        exit();
    }

    // Fetch announcement details before deletion, including the image
    $announcement_query = "SELECT announcement_title, announcement_description, announcement_date, announcement_time, announcement_status, announcement_image, ap_id FROM announcement WHERE announcement_id = ?";
    if ($announcement_stmt = $conn->prepare($announcement_query)) {
        $announcement_stmt->bind_param("i", $announcement_id);
        $announcement_stmt->execute();
        $announcement_stmt->bind_result($announcement_title, $announcement_description, $announcement_date, $announcement_time, $announcement_status, $announcement_image, $announcement_ap_id);

        if (!$announcement_stmt->fetch()) {
            $_SESSION['toastMsg'] = "Announcement not found!";
            $_SESSION['toastType'] = "toast-warning";
            $announcement_stmt->close();
            header("Location: ../../pages/content_manager/announcement");
            exit();
        }

        $announcement_stmt->close();
    } else {
        $_SESSION['toastMsg'] = "Database error while fetching announcement!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/announcement");
        exit();
    }

    // Convert data to JSON format for archive, including the image
    $archive_description = json_encode([
        "announcement_title" => $announcement_title,
        "announcement_description" => $announcement_description,
        "announcement_date" => $announcement_date,
        "announcement_time" => $announcement_time,
        "announcement_status" => $announcement_status,
        "announcement_image" => $announcement_image, // Add the image to the archive description
        "ap_id" => $announcement_ap_id
    ]);

    // Archive the announcement before deletion
    $up_id = 1; // Constant value as per requirement
    $archive_query = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id) 
                      VALUES ('announcement', ?, ?, NOW(), ?, ?)";
    if ($archive_stmt = $conn->prepare($archive_query)) {
        $archive_stmt->bind_param("issi", $announcement_id, $archive_description, $ap_id, $up_id);
        if ($archive_stmt->execute()) {
            $archive_stmt->close();
        } else {
            $_SESSION['toastMsg'] = "Database error: Unable to archive the announcement!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/announcement");
            exit();
        }
    } else {
        $_SESSION['toastMsg'] = "Error preparing archive query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/announcement");
        exit();
    }

    // Delete the announcement after successful archiving
    $delete_query = "DELETE FROM announcement WHERE announcement_id = ?";
    if ($delete_stmt = $conn->prepare($delete_query)) {
        $delete_stmt->bind_param("i", $announcement_id);
        if ($delete_stmt->execute()) {
            $delete_stmt->close();

            // Log the deletion
            $log_description = "Deleted Announcement: '$announcement_title'";
            $current_time = date("H:i:s");

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), ?, ?)";
            if ($log_stmt = $conn->prepare($log_query)) {
                $log_stmt->bind_param("ssi", $log_description, $current_time, $user_id);
                $log_stmt->execute();
                $log_stmt->close();
            }

            $_SESSION['toastMsg'] = "Announcement deleted and archived successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error deleting announcement!";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Database error: Unable to process request!";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../../pages/content_manager/announcement");
    exit();
}
// DELETE ANNOUNCEMENT END

// UPDATE ANNOUNCEMENT START
if (isset($_POST['update_announcement'])) {
    $announcement_id = intval($_POST['announcement_id']);
    $title = mysqli_real_escape_string($conn, $_POST['announcement_title']);
    $description = mysqli_real_escape_string($conn, $_POST['announcement_description']);
    $status = mysqli_real_escape_string($conn, $_POST['announcement_status']);
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$announcement_id || !$title || !$description || !$status) {
        $_SESSION['toastMsg'] = "Missing or invalid input data.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/announcement");
        exit();
    }

    $result = mysqli_query($conn, "SELECT announcement_title, announcement_description, announcement_status, announcement_image FROM announcement WHERE announcement_id = '$announcement_id'");
    if (!$result || mysqli_num_rows($result) == 0) {
        $_SESSION['toastMsg'] = "Announcement not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/announcement");
        exit();
    }
    $currentData = mysqli_fetch_assoc($result);
    $changes = [];
    if ($title !== $currentData['announcement_title'])
        $changes[] = "Title";
    if ($description !== $currentData['announcement_description'])
        $changes[] = "Description";
    if ($status !== $currentData['announcement_status'])
        $changes[] = "Status";

    $new_image = $currentData['announcement_image'];
    if (!empty($_FILES['announcement_image']['name'])) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        if (in_array($_FILES['announcement_image']['type'], $allowed_types)) {
            $upload_dir = "../../assets/uploads/announcement/";
            $file_name = uniqid() . "_" . basename($_FILES["announcement_image"]["name"]);
            $new_image = $file_name;

            if (!move_uploaded_file($_FILES["announcement_image"]["tmp_name"], $upload_dir . $file_name)) {
                $_SESSION['toastMsg'] = "Error uploading new image!";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../../pages/content_manager/announcement");
                exit();
            }
            $changes[] = "Image";
        } else {
            $_SESSION['toastMsg'] = "Invalid image format! Allowed: JPEG, JPG, PNG.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/announcement");
            exit();
        }
    }

    if (empty($changes)) {
        $_SESSION['toastMsg'] = "No changes detected.";
        $_SESSION['toastType'] = "toast-warning";
        header("Location: ../../pages/content_manager/announcement");
        exit();
    }
    $updateQuery = "UPDATE announcement SET 
                    announcement_title = '$title', 
                    announcement_description = '$description', 
                    announcement_status = '$status', 
                    announcement_image = '$new_image' 
                    WHERE announcement_id = '$announcement_id'";

    if (!mysqli_query($conn, $updateQuery)) {
        $_SESSION['toastMsg'] = "Update failed: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/announcement");
        exit();
    }

    // Now include the announcement title in the log description
    $descriptionLog = "Updated Announcement: " . $currentData['announcement_title'];
    if (!empty($changes)) {
        $descriptionLog .= " (" . implode(", ", $changes) . ")";
    }

    // Log the update
    $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                 VALUES ('$descriptionLog', NOW(), NOW(), '$user_id')";
    mysqli_query($conn, $logQuery);

    mysqli_close($conn);

    $_SESSION['toastMsg'] = "Announcement updated successfully!";
    $_SESSION['toastType'] = "toast-success";
    header("Location: ../../pages/content_manager/announcement");
    exit();
}
// UPDATE ANNOUNCEMENT END

?>
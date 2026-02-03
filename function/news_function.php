<?php
session_start();
include '../connection/dbconnection.php';
date_default_timezone_set('Asia/Phnom_Penh');

// ADD NEWS FUNCTION START
if (isset($_POST['add_news'])) {

    $news_title = $_POST['news_title'] ?? null;
    $news_description = $_POST['news_description'] ?? null;
    $news_status = 'Active'; // Force status Active
    $user_id = $_SESSION['user_id'] ?? null;
    $news_image = $_FILES['news_image'] ?? null;

    if ($news_title && $news_description && $user_id) { // No need to check $news_status because it's fixed
        $image_path = null;
        if ($news_image && $news_image['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            if (in_array($news_image['type'], $allowed_types)) {
                $upload_dir = '../assets/uploads/news/';
                $image_name = uniqid() . "_" . basename($news_image['name']);
                $image_path = $image_name;

                if (!move_uploaded_file($news_image['tmp_name'], $upload_dir . $image_name)) {
                    $_SESSION['toastMsg'] = "Failed to upload image!";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../pages/adminukt/news");
                    exit();
                }
            } else {
                $_SESSION['toastMsg'] = "Invalid image format! Allowed: JPEG, JPG, PNG.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/news");
                exit();
            }
        } else if ($news_image['error'] != 4) {
            $_SESSION['toastMsg'] = "Error uploading image! Error code: " . $news_image['error'];
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/news");
            exit();
        }

        // Fetch ap_id from authorized_person
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $ap_stmt = $conn->prepare($ap_query);
        if (!$ap_stmt) {
            $_SESSION['toastMsg'] = "Database error while fetching user details!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/news");
            exit();
        }
        $ap_stmt->bind_param("i", $user_id);
        $ap_stmt->execute();
        $ap_stmt->bind_result($ap_id);
        $ap_stmt->fetch();
        $ap_stmt->close();

        if ($ap_id) {
            $query = "INSERT INTO news (news_title, news_description, news_date, news_time, news_image, news_status, ap_id) 
                      VALUES (?, ?, CURDATE(), CURRENT_TIME(), ?, ?, ?)";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error while inserting news!";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/news");
                exit();
            }
            $stmt->bind_param("ssssi", $news_title, $news_description, $image_path, $news_status, $ap_id);

            if ($stmt->execute()) {
                $log_description = "Added News: '$news_title' with status '$news_status'";
                $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), CURRENT_TIME(), ?)";
                $log_stmt = $conn->prepare($log_query);

                if ($log_stmt) {
                    $log_stmt->bind_param("si", $log_description, $user_id);
                    $log_stmt->execute();
                    $log_stmt->close();
                }

                $_SESSION['toastMsg'] = "News added successfully!";
                $_SESSION['toastType'] = "toast-success";
            } else {
                $_SESSION['toastMsg'] = "Error adding News!";
                $_SESSION['toastType'] = "toast-error";
            }
        } else {
            $_SESSION['toastMsg'] = "No authorized person found for the user!";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "All fields are required!";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/news");
    exit();
}
// ADD NEWS FUNCTION END

// DELETE NEWS START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_news']) && !empty($_POST['news_id'])) {
    $news_id = intval($_POST['news_id']);

    // Ensure user is logged in
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Unauthorized action!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/news");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Get authorized_person ID
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
        $_SESSION['toastMsg'] = "Unauthorized person not found!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/news");
        exit();
    }

    // Fetch complete news details
    $news_data = [];
    $fetch_query = "SELECT news_id, news_title, news_description, news_date, news_time, news_image, news_status, ap_id FROM news WHERE news_id = ?";
    if ($fetch_stmt = $conn->prepare($fetch_query)) {
        $fetch_stmt->bind_param("i", $news_id);
        $fetch_stmt->execute();
        $result = $fetch_stmt->get_result();
        if ($result->num_rows > 0) {
            $news_data = $result->fetch_assoc();
        }
        $fetch_stmt->close();
    }

    if (empty($news_data)) {
        $_SESSION['toastMsg'] = "News not found!";
        $_SESSION['toastType'] = "toast-warning";
        header("Location: ../pages/adminukt/news");
        exit();
    }

    // Archive news
    $archive_description = json_encode($news_data, JSON_UNESCAPED_UNICODE);
    $original_table = "news";
    $record_id = $news_id;
    $up_id = 1; // Constant university_profile ID

    $archive_query = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id)
                    VALUES (?, ?, ?, NOW(), ?, ?)";
    if ($archive_stmt = $conn->prepare($archive_query)) {
        $archive_stmt->bind_param("sisii", $original_table, $record_id, $archive_description, $ap_id, $up_id);
        $archive_stmt->execute();
        $archive_stmt->close();
    }

    // Delete the news
    $delete_query = "DELETE FROM news WHERE news_id = ?";
    if ($delete_stmt = $conn->prepare($delete_query)) {
        $delete_stmt->bind_param("i", $news_id);

        if ($delete_stmt->execute()) {
            $delete_stmt->close();

            // Log the deletion
            $log_description = "Deleted News: '" . $news_data['news_title'] . "'";
            $current_time = date("H:i:s");

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), ?, ?)";
            if ($log_stmt = $conn->prepare($log_query)) {
                $log_stmt->bind_param("ssi", $log_description, $current_time, $user_id);
                $log_stmt->execute();
                $log_stmt->close();
            }

            $_SESSION['toastMsg'] = "News archived and deleted successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error deleting news!";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Database error: Unable to process deletion!";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/news");
    exit();
}
// DELETE NEWS END

// UPDATE NEWS START
if (isset($_POST['update_news'])) {

    $news_id = intval($_POST['news_id']);
    $title = mysqli_real_escape_string($conn, $_POST['news_title']);
    $description = mysqli_real_escape_string($conn, $_POST['news_description']);
    $status = mysqli_real_escape_string($conn, $_POST['news_status']);
    $news_date = mysqli_real_escape_string($conn, $_POST['news_date']);
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$news_id || !$title || !$description || !$status || !$news_date) {
        $_SESSION['toastMsg'] = "Missing or invalid input data.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/news");
        exit();
    }

    // Fetch current news data before updating
    $result = mysqli_query($conn, "SELECT news_title, news_description, news_status, news_image FROM news WHERE news_id = '$news_id'");
    if (!$result || mysqli_num_rows($result) == 0) {
        $_SESSION['toastMsg'] = "News not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/news");
        exit();
    }
    $currentData = mysqli_fetch_assoc($result);

    // Track changes
    $changes = [];
    if ($title !== $currentData['news_title'])
        $changes[] = "Title";
    if ($description !== $currentData['news_description'])
        $changes[] = "Description";
    if ($status !== $currentData['news_status'])
        $changes[] = "Status";

    // Handle image upload
    $new_image = $currentData['news_image']; // Keep old image by default
    if (!empty($_FILES['news_image']['name'])) {
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        if (in_array($_FILES['news_image']['type'], $allowed_types)) {
            $upload_dir = "../assets/uploads/news/";
            $file_name = uniqid() . "_" . basename($_FILES["news_image"]["name"]);
            $new_image = $file_name; // Store new file name in database

            if (!move_uploaded_file($_FILES["news_image"]["tmp_name"], $upload_dir . $file_name)) {
                $_SESSION['toastMsg'] = "Error uploading new image!";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/news");
                exit();
            }
            $changes[] = "Image";
        } else {
            $_SESSION['toastMsg'] = "Invalid image format! Allowed: JPEG, JPG, PNG.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/news");
            exit();
        }
    }

    // If no changes detected, stop execution
    if (empty($changes)) {
        $_SESSION['toastMsg'] = "No changes detected.";
        $_SESSION['toastType'] = "toast-warning";
        header("Location: ../pages/adminukt/news");
        exit();
    }

    // Update news
    $updateQuery = "UPDATE news SET 
                    news_title = '$title', 
                    news_description = '$description', 
                    news_status = '$status', 
                    news_date = '$news_date', 
                    news_image = '$new_image' 
                    WHERE news_id = '$news_id'";

    if (!mysqli_query($conn, $updateQuery)) {
        $_SESSION['toastMsg'] = "Update failed: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/news");
        exit();
    }

    // Insert into history_log with dynamic description
    $descriptionLog = "Updated News: " . implode(", ", $changes);
    $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                 VALUES ('$descriptionLog', NOW(), NOW(), '$user_id')";
    mysqli_query($conn, $logQuery);

    mysqli_close($conn);

    $_SESSION['toastMsg'] = "News updated successfully!";
    $_SESSION['toastType'] = "toast-success";
    header("Location: ../pages/adminukt/news");
    exit();
}
// UPDATE NEWS END
?>
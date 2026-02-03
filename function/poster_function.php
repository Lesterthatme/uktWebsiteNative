<?php
session_start();
include '../connection/dbconnection.php';
date_default_timezone_set('Asia/Phnom_Penh');

// ADD POSTER START
if (isset($_POST['add_poster'])) {

    $poster_status = 'Active'; // Force status Active
    $user_id = $_SESSION['user_id'] ?? null;
    $poster_image = $_FILES['poster_image'] ?? null;

    if ($user_id) { // No need to check $poster_status since it's fixed
        $image_path = null;
        if ($poster_image && $poster_image['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
            if (in_array($poster_image['type'], $allowed_types)) {
                $upload_dir = '../assets/uploads/poster/';
                $image_name = uniqid() . "_" . basename($poster_image['name']);
                $image_path = $image_name;

                if (!move_uploaded_file($poster_image['tmp_name'], $upload_dir . $image_name)) {
                    $_SESSION['toastMsg'] = "Failed to upload image! Check file permissions or path.";
                    $_SESSION['toastType'] = "toast-error";
                    header("Location: ../pages/adminukt/page_poster");
                    exit();
                }
            } else {
                $_SESSION['toastMsg'] = "Invalid image format! Allowed types: JPEG, JPG, PNG.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/page_poster");
                exit();
            }
        } else if ($poster_image['error'] != 4) { // 4 means no file uploaded
            $_SESSION['toastMsg'] = "Error uploading image! Error code: " . $poster_image['error'];
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/page_poster");
            exit();
        }

        // Fetch authorized person
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $ap_stmt = $conn->prepare($ap_query);
        if (!$ap_stmt) {
            $_SESSION['toastMsg'] = "Database error while fetching authorized person!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/page_poster");
            exit();
        }
        $ap_stmt->bind_param("i", $user_id);
        $ap_stmt->execute();
        $ap_stmt->bind_result($ap_id);
        $ap_stmt->fetch();
        $ap_stmt->close();

        if ($ap_id) {
            $query = "INSERT INTO page_poster (poster_date, poster_time, poster_image, poster_status, ap_id) 
                      VALUES (CURDATE(), CURRENT_TIME(), ?, ?, ?)";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error while preparing insert poster query!";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/page_poster");
                exit();
            }
            $stmt->bind_param("ssi", $image_path, $poster_status, $ap_id);

            if ($stmt->execute()) {
                $log_description = "Added a new poster with status: '$poster_status'";
                $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                              VALUES (?, CURDATE(), CURRENT_TIME(), ?)";
                $log_stmt = $conn->prepare($log_query);

                if ($log_stmt) {
                    $log_stmt->bind_param("si", $log_description, $user_id);
                    $log_stmt->execute();
                    $log_stmt->close();

                    $_SESSION['toastMsg'] = "Poster added and logged successfully!";
                    $_SESSION['toastType'] = "toast-success";
                } else {
                    $_SESSION['toastMsg'] = "Poster added, but logging failed!";
                    $_SESSION['toastType'] = "toast-warning";
                }
            } else {
                $_SESSION['toastMsg'] = "Error adding poster!";
                $_SESSION['toastType'] = "toast-error";
            }
        } else {
            $_SESSION['toastMsg'] = "No authorized person found for the logged-in user!";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "All fields are required!";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/page_poster");
    exit();
}
// ADD POSTER END

// DELETE POSTER START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && !empty($_POST['poster_id'])) {
    $poster_id = intval($_POST['poster_id']);

    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Unauthorized action!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/page_poster");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Fetch poster details for archiving
    $fetch_query = "SELECT poster_image, poster_status, poster_date, poster_time, ap_id FROM page_poster WHERE poster_id = ?";
    if ($fetch_stmt = $conn->prepare($fetch_query)) {
        $fetch_stmt->bind_param("i", $poster_id);
        $fetch_stmt->execute();
        $fetch_stmt->bind_result($poster_image, $poster_status, $poster_date, $poster_time, $ap_id);
        
        if (!$fetch_stmt->fetch()) {
            $_SESSION['toastMsg'] = "Poster not found!";
            $_SESSION['toastType'] = "toast-warning";
            $fetch_stmt->close();
            header("Location: ../pages/adminukt/page_poster");
            exit();
        }
        $fetch_stmt->close();
    } else {
        $_SESSION['toastMsg'] = "Database error while fetching poster!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/page_poster");
        exit();
    }

    // Get authorized person (ap_id) of current user
    $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
    $ap_stmt = $conn->prepare($ap_query);
    $ap_stmt->bind_param("i", $user_id);
    $ap_stmt->execute();
    $ap_stmt->bind_result($archived_by);
    if (!$ap_stmt->fetch()) {
        $ap_stmt->close();
        $_SESSION['toastMsg'] = "Authorized person not found!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/page_poster");
        exit();
    }
    $ap_stmt->close();

    // Hardcoded university profile ID
    $up_id = 1;

    // Archive data as JSON
    $archive_description = json_encode([
        'poster_id' => $poster_id,
        'poster_image' => $poster_image,
        'poster_status' => $poster_status,
        'poster_date' => $poster_date,
        'poster_time' => $poster_time,
        'ap_id' => $ap_id
    ]);

    $archive_query = "INSERT INTO university_archive 
        (original_table, record_id, archive_description, archived_at, archived_by, up_id)
        VALUES ('page_poster', ?, ?, NOW(), ?, ?)";
    $archive_stmt = $conn->prepare($archive_query);
    $archive_stmt->bind_param("isii", $poster_id, $archive_description, $archived_by, $up_id);
    $archive_stmt->execute();
    $archive_stmt->close();

    // Delete the poster
    $delete_query = "DELETE FROM page_poster WHERE poster_id = ?";
    if ($delete_stmt = $conn->prepare($delete_query)) {
        $delete_stmt->bind_param("i", $poster_id);

        if ($delete_stmt->execute()) {
            $delete_stmt->close();

            $log_description = "Deleted poster: '$poster_image'";
            $current_time = date("H:i:s");

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), ?, ?)";
            if ($log_stmt = $conn->prepare($log_query)) {
                $log_stmt->bind_param("ssi", $log_description, $current_time, $user_id);
                $log_stmt->execute();
                $log_stmt->close();
            }

            $_SESSION['toastMsg'] = "Poster deleted and archived successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error deleting poster!";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Database error: Unable to process request!";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/page_poster");
    exit();
}
// DELETE POSTER END

// UPDATE POSTER START
if (isset($_POST['update_poster'])) {

    $poster_id = $_POST['poster_id'];
    $poster_status = $_POST['poster_status'];
    $poster_date = $_POST['poster_date'];
    $poster_time = date("H:i:s"); 
    $user_id = $_SESSION['user_id'] ?? null;

    $fetch_query = "SELECT poster_image, poster_status FROM page_poster WHERE poster_id = ?";
    $fetch_stmt = $conn->prepare($fetch_query);
    if (!$fetch_stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing fetch query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/page_poster");
        exit;
    }
    $fetch_stmt->bind_param("i", $poster_id);
    $fetch_stmt->execute();
    $fetch_stmt->bind_result($old_image, $old_status);
    $fetch_stmt->fetch();
    $fetch_stmt->close();

    $changes = [];
    if ($poster_status !== $old_status)
        $changes[] = "Status";


    $new_image = $old_image;
    if (!empty($_FILES['poster_image']['name'])) {
        $target_dir = "../assets/uploads/poster/";
        $file_name = basename($_FILES["poster_image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["poster_image"]["tmp_name"], $target_file)) {
            $new_image = $file_name;
            $changes[] = "Image";
        } else {
            $_SESSION['toastMsg'] = "Error uploading image!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/page_poster");
            exit;
        }
    }


    if (empty($changes)) {
        $_SESSION['toastMsg'] = "No changes detected.";
        $_SESSION['toastType'] = "toast-warning";
        header("Location: ../pages/adminukt/page_poster");
        exit();
    }


    $update_query = "UPDATE page_poster SET poster_image=?, poster_status=?, poster_date=?, poster_time=? WHERE poster_id=?";
    $stmt = $conn->prepare($update_query);
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error while preparing update query!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/page_poster");
        exit;
    }
    $stmt->bind_param("ssssi", $new_image, $poster_status, $poster_date, $poster_time, $poster_id);

    if ($stmt->execute()) {
        $descriptionLog = "Updated Poster: " . implode(", ", $changes);
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), ?, ?)";
        $log_stmt = $conn->prepare($log_query);
        if (!$log_stmt) {
            $_SESSION['toastMsg'] = "Database error while preparing log query!";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/page_poster");
            exit;
        }
        $log_stmt->bind_param("ssi", $descriptionLog, $poster_time, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "Poster updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Update failed! Please try again.";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    mysqli_close($conn);
    header("Location: ../pages/adminukt/page_poster");
    exit();
}
// UPDATE POSTER END
?>
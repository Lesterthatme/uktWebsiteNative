<?php
include '../connection/dbconnection.php';
session_start();

date_default_timezone_set('Asia/Phnom_Penh');

// ADD EVENT FUNCTION START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uc_title'])) {
    $uc_month = $_POST['uc_month'] ?? null;
    $uc_day = $_POST['uc_day'] ?? null;
    $uc_title = $_POST['uc_title'] ?? null;
    $uc_description = $_POST['uc_description'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    if ($uc_month && $uc_day && $uc_title && $uc_description && $user_id) {

        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $ap_stmt = $conn->prepare($ap_query);
        $ap_stmt->bind_param("i", $user_id);
        $ap_stmt->execute();
        $ap_stmt->bind_result($ap_id);
        $ap_stmt->fetch();
        $ap_stmt->close();

        if ($ap_id) {

            $query = "INSERT INTO university_calendar (uc_title, uc_month, uc_day, uc_description, uc_dateposted, uc_timeposted, ap_id) 
                      VALUES (?, ?, ?, ?, CURDATE(), CURRENT_TIME(), ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssisi", $uc_title, $uc_month, $uc_day, $uc_description, $ap_id);

            if ($stmt->execute()) {

                $log_description = "Added a new calendar event: $uc_title";
                $current_time = date("H:i:s");
                $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), ?, ?)";
                $log_stmt = $conn->prepare($log_query);
                $log_stmt->bind_param("ssi", $log_description, $current_time, $user_id);
                $log_stmt->execute();
                $log_stmt->close();

                $_SESSION['toastMsg'] = "Event added successfully!";
                $_SESSION['toastType'] = "toast-success";
            } else {
                $_SESSION['toastMsg'] = "Error adding event: " . $stmt->error;
                $_SESSION['toastType'] = "toast-error";
            }
            $stmt->close();
        } else {
            $_SESSION['toastMsg'] = "No authorized person found for the logged-in user!";
            $_SESSION['toastType'] = "toast-warning";
        }
    } else {
        $_SESSION['toastMsg'] = "All fields are required!";
        $_SESSION['toastType'] = "toast-error";
    }
    header("Location: ../pages/adminukt/calendar");
    exit();
}
// ADD EVENT FUNCTION END

// DELETE FUNCTION START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && !empty($_POST['uc_id'])) {
    $uc_id = intval($_POST['uc_id']);

    // Ensure user is logged in
    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
        $_SESSION['toastMsg'] = "Unauthorized action!";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/calendar");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    // Retrieve `ap_id` from `authorized_person`
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
        $_SESSION['toastMsg'] = "Authorization error.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/calendar");
        exit();
    }

    // Fetch event details before deletion
    $event_details = [];
    $select_query = "SELECT uc_title, uc_month, uc_day, uc_description, uc_dateposted, uc_timeposted, ap_id 
                     FROM university_calendar WHERE uc_id = ?";
    if ($select_stmt = $conn->prepare($select_query)) {
        $select_stmt->bind_param("i", $uc_id);
        $select_stmt->execute();
        $select_stmt->bind_result($uc_title, $uc_month, $uc_day, $uc_description, $uc_dateposted, $uc_timeposted, $event_ap_id);
        if ($select_stmt->fetch()) {
            $event_details = [
                "uc_title" => $uc_title,
                "uc_month" => $uc_month,
                "uc_day" => $uc_day,
                "uc_description" => $uc_description,
                "uc_dateposted" => $uc_dateposted,
                "uc_timeposted" => $uc_timeposted,
                "ap_id" => $event_ap_id
            ];
        }
        $select_stmt->close();
    }

    if (empty($event_details)) {
        $_SESSION['toastMsg'] = "Event not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/calendar");
        exit();
    }

    // Convert event details to JSON
    $archive_description = json_encode($event_details);

    // Insert into `university_archive`
    $archive_query = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id) 
                      VALUES ('university_calendar', ?, ?, NOW(), ?, 1)";
    if ($archive_stmt = $conn->prepare($archive_query)) {
        $archive_stmt->bind_param("isi", $uc_id, $archive_description, $ap_id);
        $archive_stmt->execute();
        $archive_stmt->close();
    } else {
        $_SESSION['toastMsg'] = "Error archiving event.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/calendar");
        exit();
    }

    // Delete the event
    $delete_query = "DELETE FROM university_calendar WHERE uc_id = ?";
    if ($delete_stmt = $conn->prepare($delete_query)) {
        $delete_stmt->bind_param("i", $uc_id);
        if ($delete_stmt->execute()) {
            $delete_stmt->close();

            // Log the deletion
            $log_description = "Deleted event: '$uc_title'";
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            if ($log_stmt = $conn->prepare($log_query)) {
                $log_stmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
                $log_stmt->execute();
                $log_stmt->close();
            }

            $_SESSION['toastMsg'] = "Event deleted and archived successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error deleting the event: " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Database error: Unable to process request.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/calendar");
    exit();
}
// DELETE FUNCTION END

?>
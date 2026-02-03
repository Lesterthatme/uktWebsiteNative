<?php
session_start();
include '../connection/dbconnection.php';


date_default_timezone_set('Asia/Phnom_Penh');

// ADD HIGHLIGHTS FUNCTION START
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_highlights'])) {
    
    $icon = $_POST['icon_class'] ?? null;
    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;
    $user_id = $_SESSION['user_id'] ?? null;

    if (!$icon || !$title || !$description || !$user_id) {
        $_SESSION['toastMsg'] = "All fields are required!";
        $_SESSION['toastType'] = "toast-warning";
        header('Location: ../pages/adminukt/page_management');
        exit();
    }

    // Check if user is authorized
    $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $ap_query);
    mysqli_stmt_bind_param($stmt, "s", $user_id);
    mysqli_stmt_execute($stmt);
    $ap_result = mysqli_stmt_get_result($stmt);
    $ap_row = mysqli_fetch_assoc($ap_result);
    $ap_id = $ap_row['ap_id'] ?? null;
    mysqli_stmt_close($stmt);

    if (!$ap_id) {
        $_SESSION['toastMsg'] = "Unauthorized action!";
        $_SESSION['toastType'] = "toast-error";
        header('Location: ../pages/adminukt/page_management');
        exit();
    }

    // Insert highlight
    $query = "INSERT INTO highlight (h_icon, h_title, h_description, h_date, h_time, ap_id) 
              VALUES (?, ?, ?, CURDATE(), CURRENT_TIME(), ?)";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        $_SESSION['toastMsg'] = "SQL Error: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
        header('Location: ../pages/adminukt/page_management');
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $icon, $title, $description, $ap_id);
    $execute = mysqli_stmt_execute($stmt);
    
    if ($execute) {
        // Log the action
        $log_description = "Added a new highlight: '$title'";
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES (?, CURDATE(), CURRENT_TIME(), ?)";
        $log_stmt = mysqli_prepare($conn, $log_query);
        mysqli_stmt_bind_param($log_stmt, "ss", $log_description, $user_id);
        mysqli_stmt_execute($log_stmt);
        mysqli_stmt_close($log_stmt);

        $_SESSION['toastMsg'] = "Highlight added successfully!";
        $_SESSION['toastType'] = "toast-success";

        // Redirect to the desired page after successful insertion
        header('Location: ../pages/adminukt/page_management');
        exit();
    } else {
        $_SESSION['toastMsg'] = "Error adding highlight: " . mysqli_stmt_error($stmt);
        $_SESSION['toastType'] = "toast-error";
        header('Location: ../pages/adminukt/page_management');
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
// ADD HIGHLIGHTS FUNCTION END


// START >> DELETE FUNCTION OF HIGHLIGHT
if (isset($_GET['h_id'])) {
    $h_id = intval($_GET['h_id']); 

    // Retrieve highlight details before deletion
    $queryGetHighlight = "SELECT * FROM highlight WHERE h_id = ?";
    $stmtGetHighlight = $conn->prepare($queryGetHighlight);
    $stmtGetHighlight->bind_param("i", $h_id);
    $stmtGetHighlight->execute();
    $result = $stmtGetHighlight->get_result();

    if ($result->num_rows > 0) {
        $highlight = $result->fetch_assoc();
        $highlightTitle = $highlight['h_title'];
        $highlightDescription = json_encode($highlight, JSON_UNESCAPED_UNICODE); // Store as JSON

        // Get authorized person's ID (ap_id) from session user_id
        $user_id = $_SESSION['user_id'] ?? null;

        if (!$user_id) {
            $_SESSION['toastMsg'] = "Session expired. Please log in again.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/page_management");
            exit();
        }

        $auth_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $auth_stmt = $conn->prepare($auth_query);
        $auth_stmt->bind_param("i", $user_id);
        $auth_stmt->execute();
        $auth_result = $auth_stmt->get_result();
        $auth_row = $auth_result->fetch_assoc();
        $ap_id = $auth_row['ap_id'] ?? null;

        if (!$ap_id) {
            $_SESSION['toastMsg'] = "Error: Unauthorized action.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/page_management");
            exit();
        }

        // Archive the highlight
        $up_id = 1; // Constant value for up_id
        $archivedAt = date("Y-m-d H:i:s");
        $originalTable = 'highlight';

        $archiveQuery = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $archiveStmt = $conn->prepare($archiveQuery);
        $archiveStmt->bind_param("sissii", $originalTable, $h_id, $highlightDescription, $archivedAt, $ap_id, $up_id);
        $archiveSuccess = $archiveStmt->execute();
        
        if ($archiveSuccess) {
            // Delete the highlight after archiving
            $queryDelete = "DELETE FROM highlight WHERE h_id = ?";
            $stmtDelete = $conn->prepare($queryDelete);
            $stmtDelete->bind_param("i", $h_id);

            if ($stmtDelete->execute()) {
                // Log the deletion into history_log
                $description = "Deleted highlight: $highlightTitle";
                $log_date = date("Y-m-d");
                $log_time = date("H:i:s");

                $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                            VALUES (?, ?, ?, ?)";
                $logStmt = $conn->prepare($logQuery);
                $logStmt->bind_param("sssi", $description, $log_date, $log_time, $user_id);
                $logStmt->execute();

                $_SESSION['toastMsg'] = "Highlight archived and deleted successfully!";
                $_SESSION['toastType'] = "toast-success";
            } else {
                $_SESSION['toastMsg'] = "Error deleting highlight.";
                $_SESSION['toastType'] = "toast-error";
            }
        } else {
            $_SESSION['toastMsg'] = "Error archiving highlight.";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Highlight not found.";
        $_SESSION['toastType'] = "toast-warning";
    }

    header("Location: ../pages/adminukt/page_management");
    exit();
}
// END >> DELETE FUNCTION OF HIGHLIGHT


?>

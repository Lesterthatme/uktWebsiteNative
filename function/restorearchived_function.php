<?php
session_start();
include '../connection/dbconnection.php';
date_default_timezone_set('Asia/Phnom_Penh');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['toastMsg'] = "Unauthorized access.";
    $_SESSION['toastType'] = "toast-error";
    header("Location: ../pages/adminukt/login");
    exit();
}

$user_id = $_SESSION['user_id']; 

//restoring and permanent delete highlights function start
if (isset($_GET['restorehighlight_id'])) {
    $restorehighlight_id = intval($_GET['restorehighlight_id']);

    $query = "SELECT original_table, archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive");
        exit();
    }

    $stmt->bind_param("i", $restorehighlight_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive");
            exit();
        }

        // Extract h_title  for logging
        $h_title = isset($archive_description['h_title']) ? $archive_description['h_title'] : 'Unknown Subject';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive");
            exit();
        }

        $types = str_repeat("s", count($values)); 
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);

            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error (DELETE): " . $conn->error;
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive");
                exit();
            }

            $stmt->bind_param("i", $restorehighlight_id); 
            $stmt->execute();

            // Insert into history_log table
            $logDescription = "Restored the highlight: ' $h_title'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "Highlight restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore highlight: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Highlight not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive");
    exit();
}

// Permanent Delete Highlight Function
if (isset($_GET['deletehighlight_id'])) {
    $record_id = intval($_GET['deletehighlight_id']); // Prevent SQL Injection

    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $h_title = "Unknown Subject"; // Default if not found
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['h_title'])) {
            $h_title = $archive_description['h_title'];
        }
    }

    // Delete the highlight from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent delete the highlight: '$h_title'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "Highlights permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete Highlight: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../pages/adminukt/archive");
    exit();
}
//restoring and permanent delete highlights function start

// Restore and delete function for partnership START
if (isset($_GET['restorepartnership_id'])) {
    $restorepartnership_id = intval($_GET['restorepartnership_id']);

    $query = "SELECT original_table, archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive_partnership");
        exit();
    }

    $stmt->bind_param("i", $restorepartnership_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_partnership");
            exit();
        }

        // Extract up_name  for logging
        $up_name = isset($archive_description['up_name']) ? $archive_description['up_name'] : 'Unknown Subject';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_partnership");
            exit();
        }

        $types = str_repeat("s", count($values)); 
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);

            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error (DELETE): " . $conn->error;
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_partnership");
                exit();
            }

            $stmt->bind_param("i", $restorepartnership_id); 
            $stmt->execute();

            // Insert into history_log table
            $logDescription = "Restored the University Partnership: '$up_name'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "University Partnership restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore University Partnership: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "University Partnership not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_partnership");
    exit();
}

// Permanent Delete Partnership Function
if (isset($_GET['deletepartnership_id'])) {
    $record_id = intval($_GET['deletepartnership_id']); // Prevent SQL Injection

    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $up_name = "Unknown Subject"; // Default if not found
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['up_name'])) {
            $up_name = $archive_description['up_name'];
        }
    }

    // Delete the University Partnership from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent delete the University Partnership: '$up_name'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "University Partnership permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete University Partnership: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location:  ../pages/adminukt/archive_partnership");
    exit();
}
// Restore and delete function for partnership End


// Restore and delete function for UNIVERSITY CALENDAR event START
if (isset($_GET['restoreevent_id'])) {
    $restoreevent_id = intval($_GET['restoreevent_id']);

    $query = "SELECT original_table, archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive_calendar");
        exit();
    }

    $stmt->bind_param("i", $restoreevent_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_calendar");
            exit();
        }

        // Extract uc_title  for logging
        $uc_title = isset($archive_description['uc_title']) ? $archive_description['uc_title'] : 'Unknown Subject';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_calendar");
            exit();
        }

        $types = str_repeat("s", count($values)); 
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);

            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error (DELETE): " . $conn->error;
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_calendar");
                exit();
            }

            $stmt->bind_param("i", $restoreevent_id); 
            $stmt->execute();

            // Insert into history_log table
            $logDescription = "Restored the University Calendar Event: '$uc_title'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "University Calendar Event restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore University Calendar Event: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "University Calendar Event not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_calendar");
    exit();
}

// Permanent Delete university calendar Function
if (isset($_GET['deleteevent_id'])) {
    $record_id = intval($_GET['deleteevent_id']); // Prevent SQL Injection

    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $uc_title  = "Unknown Subject"; // Default if not found
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['uc_title'])) {
            $uc_title = $archive_description['uc_title'];
        }
    }

    // Delete the highlight from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent Deleted the event: '$uc_title'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "University Calendar permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete University Calendar: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../pages/adminukt/archive_calendar");
    exit();
}
// Restore and delete function for  UNIVERSITY CALENDAR event End

// Restore and delete function for FAQ START
if (isset($_GET['restorefaq_id'])) {
    $restorefaq_id = intval($_GET['restorefaq_id']);

    $query = "SELECT original_table, archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive_faq");
        exit();
    }

    $stmt->bind_param("i", $restorefaq_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_faq");
            exit();
        }

        // Extract uc_title  for logging
        $faq_question = isset($archive_description['faq_question']) ? $archive_description['faq_question'] : 'Unknown Subject';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_faq");
            exit();
        }

        $types = str_repeat("s", count($values)); 
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);

            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error (DELETE): " . $conn->error;
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_faq");
                exit();
            }

            $stmt->bind_param("i", $restorefaq_id); 
            $stmt->execute();

            // Insert into history_log table
            $logDescription = "Restored FAQ: '$faq_question'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "FAQ restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore FAQ: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "FAQ not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_faq");
    exit();
}

// Permanent Delete faq Function
if (isset($_GET['deletefaq_id'])) {
    $record_id = intval($_GET['deletefaq_id']); // Prevent SQL Injection

    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $faq_question  = "Unknown Subject"; // Default if not found
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['faq_question'])) {
            $faq_question = $archive_description['faq_question'];
        }
    }

    // Delete the highlight from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent Deleted FAQ: '$faq_question'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "FAQ permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete FAQ: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../pages/adminukt/archive_faq");
    exit();
}
// Restore and delete function for FAQ End

// Restore and delete function for ANNOUNCEMENT START
if (isset($_GET['restoreannouncement_id'])) {
    $restoreannouncement_id = intval($_GET['restoreannouncement_id']);

    $query = "SELECT original_table, archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive_announcement");
        exit();
    }

    $stmt->bind_param("i", $restoreannouncement_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_announcement");
            exit();
        }

        // Extract announcement_title for logging
        $announcement_title = isset($archive_description['announcement_title']) ? $archive_description['announcement_title'] : 'Unknown Subject';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_announcement");
            exit();
        }

        $types = str_repeat("s", count($values)); 
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);

            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error (DELETE): " . $conn->error;
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_announcement");
                exit();
            }

            $stmt->bind_param("i", $restoreannouncement_id);
            $stmt->execute();

            // Insert into history_log table
            $logDescription = "Restored the Announcement: '$announcement_title'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "Announcement restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore announcement: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Announcement not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_announcement");
    exit();
}

// Permanent Delete announcementFunction
if (isset($_GET['deleteannouncement_id'])) {
    $record_id = intval($_GET['deleteannouncement_id']); // Prevent SQL Injection

    // Fetch the deleteannouncement_id before deleting
    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $announcement_title= "Unknown Subject"; // Default if not found
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['announcement_title'])) {
            $announcement_title = $archive_description['announcement_title'];
        }
    }

    // Delete the announcement from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent delete the announcement: '$announcement_title'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "Announcement permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete announcement: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../pages/adminukt/archive_announcement");
    exit();
}
// Restore and delete function for ANNOUNCEMENT End


// Restore and delete function for message START
if (isset($_GET['restoremessage_id'])) {
    $restoremessage_id = intval($_GET['restoremessage_id']);

    $query = "SELECT original_table, archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive_message");
        exit();
    }

    $stmt->bind_param("i", $restoremessage_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_message");
            exit();
        }

        // Extract message_subject for logging
        $message_subject = isset($archive_description['message_subject']) ? $archive_description['message_subject'] : 'Unknown Subject';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_message");
            exit();
        }

        $types = str_repeat("s", count($values)); 
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);

            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error (DELETE): " . $conn->error;
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_message");
                exit();
            }

            $stmt->bind_param("i", $restoremessage_id);
            $stmt->execute();

            // Insert into history_log table
            $logDescription = "Restored the message subject: '$message_subject'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "Message restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore Message: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Message not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_message");
    exit();
}

// Permanent Delete Message Function
if (isset($_GET['deletemessage_id'])) {
    $record_id = intval($_GET['deletemessage_id']); // Prevent SQL Injection

    // Fetch the message_subject before deleting
    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $message_subject = "Unknown Subject"; // Default if not found
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['message_subject'])) {
            $message_subject = $archive_description['message_subject'];
        }
    }

    // Delete the message from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent delete the message: '$message_subject'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "Message permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete message: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../pages/adminukt/archive_message");
    exit();
}
// Restore and delete function for message end

// Restore gallery start
if (isset($_GET['restoregallery_id']) && isset($_GET['item_type'])) {
    $id = $_GET['restoregallery_id'];
    $itemType = $_GET['item_type'];
    $restored = false;
    $logDescription = "";

    if ($itemType === 'Image') {
        $sql = "SELECT * FROM university_image_archive WHERE image_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            $insert = $conn->prepare("INSERT INTO university_image (image_id, image_name, upload_date, album_id) VALUES (?, ?, ?, ?)");
            $insert->bind_param("issi", $result['image_id'], $result['image_name'], $result['upload_date'], $result['album_id']);
            $restored = $insert->execute();

            if ($restored) {
                $delete = $conn->prepare("DELETE FROM university_image_archive WHERE image_id = ?");
                $delete->bind_param("i", $id);
                $delete->execute();

                $logDescription = "Restored image: '{$result['image_name']}' from archive.";
            }
        }

    } elseif ($itemType === 'Album') {
        $sql = "SELECT * FROM university_album_archive WHERE album_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $album = $stmt->get_result()->fetch_assoc();

        if ($album) {
            $insertAlbum = $conn->prepare("INSERT INTO university_album (album_id, album_name, album_description, date_created, status, ap_id, up_id) VALUES (?, ?, ?, ?, ?, ?, 1)");
            $insertAlbum->bind_param("issssi", $album['album_id'], $album['album_name'], $album['album_description'], $album['date_created'], $album['status'], $album['ap_id']);
            $restored = $insertAlbum->execute();

            if ($restored) {
                $images = $conn->prepare("SELECT * FROM university_image_archive WHERE album_id = ?");
                $images->bind_param("i", $id);
                $images->execute();
                $resultImages = $images->get_result();

                while ($image = $resultImages->fetch_assoc()) {
                    $insertImage = $conn->prepare("INSERT INTO university_image (image_id, image_name, upload_date, album_id) VALUES (?, ?, ?, ?)");
                    $insertImage->bind_param("issi", $image['image_id'], $image['image_name'], $image['upload_date'], $image['album_id']);
                    $insertImage->execute();

                    $deleteImg = $conn->prepare("DELETE FROM university_image_archive WHERE image_id = ?");
                    $deleteImg->bind_param("i", $image['image_id']);
                    $deleteImg->execute();
                }

                $deleteAlbum = $conn->prepare("DELETE FROM university_album_archive WHERE album_id = ?");
                $deleteAlbum->bind_param("i", $id);
                $deleteAlbum->execute();

                $logDescription = "Restored album: '{$album['album_name']}' and its images from archive.";
            }
        }
    }

    if (!empty($logDescription) && $restored) {
        $logDate = date("Y-m-d");
        $logTime = date("H:i:s");
        $user_id = $_SESSION['user_id'] ?? 0; 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $logStmt = $conn->prepare($logQuery);
        $logStmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $logStmt->execute();
    }

    if ($restored) {
        $_SESSION['toastMsg'] = ($itemType === 'Image') ? "Image restored successfully!" : "Album and its images restored successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to restore the selected item.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_album");
    exit;
}

// Permanent Delete Gallery Start
if (isset($_GET['deletegallery_id']) && isset($_GET['item_type'])) {
    $id = intval($_GET['deletegallery_id']);
    $itemType = $_GET['item_type'];
    $deleted = false;
    $logDescription = "";

    if ($itemType === 'Image') {
        $fetch = $conn->prepare("SELECT image_name FROM university_image_archive WHERE image_id = ?");
        $fetch->bind_param("i", $id);
        $fetch->execute();
        $result = $fetch->get_result()->fetch_assoc();
        $imageName = $result['image_name'] ?? "Unknown Image";

        $stmt = $conn->prepare("DELETE FROM university_image_archive WHERE image_id = ?");
        $stmt->bind_param("i", $id);
        $deleted = $stmt->execute();

        if ($deleted) {
            $logDescription = "Permanently deleted image: '{$imageName}' from archive.";
        }

    } elseif ($itemType === 'Album') {
        $fetch = $conn->prepare("SELECT album_name FROM university_album_archive WHERE album_id = ?");
        $fetch->bind_param("i", $id);
        $fetch->execute();
        $album = $fetch->get_result()->fetch_assoc();
        $albumName = $album['album_name'] ?? "Unknown Album";

        $stmt1 = $conn->prepare("DELETE FROM university_image_archive WHERE album_id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        $stmt2 = $conn->prepare("DELETE FROM university_album_archive WHERE album_id = ?");
        $stmt2->bind_param("i", $id);
        $deleted = $stmt2->execute();

        if ($deleted) {
            $logDescription = "Permanently deleted album: '{$albumName}' and its archived images.";
        }
    }

    if (!empty($logDescription) && $deleted) {
        $logDate = date("Y-m-d");
        $logTime = date("H:i:s");
        $user_id = $_SESSION['user_id'] ?? 0;

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $logStmt = $conn->prepare($logQuery);
        $logStmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $logStmt->execute();
    }

    if ($deleted) {
        $_SESSION['toastMsg'] = ($itemType === 'Image') ? "Image permanently deleted!" : "Album permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete item.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_album");
    exit;
}
// Restore and delete function for gallery  end

// Restore and delete function for NEWS START
if (isset($_GET['restorenews_id'])) {
    $restorenews_id = intval($_GET['restorenews_id']);

    $query = "SELECT original_table, archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive_news");
        exit();
    }

    $stmt->bind_param("i", $restorenews_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_news");
            exit();
        }

        // Extract news_title for logging
        $news_title = isset($archive_description['news_title']) ? $archive_description['news_title'] : 'Unknown Subject';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_news");
            exit();
        }

        $types = str_repeat("s", count($values)); 
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);

            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error (DELETE): " . $conn->error;
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_news");
                exit();
            }

            $stmt->bind_param("i", $restorenews_id);
            $stmt->execute();

            // Insert into history_log table
            $logDescription = "Restored the News: '$news_title'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "News restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore news: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "News not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_news");
    exit();
}

// Permanent Delete news Function
if (isset($_GET['deletenews_id'])) {
    $record_id = intval($_GET['deletenews_id']); // Prevent SQL Injection

    // Fetch the deletenews_id before deleting
    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $news_title= "Unknown Subject"; // Default if not found
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['news_title'])) {
            $news_title = $archive_description['news_title'];
        }
    }

    // Delete the news from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent deleted the News: '$news_title'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "News permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete news: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../pages/adminukt/archive_news");
    exit();
}
// Restore and delete function for NEWS END


// Restore and delete function for PAGE POSTER START
if (isset($_GET['restoreposter_id'])) {
    $restoreposter_id = intval($_GET['restoreposter_id']);

    $query = "SELECT original_table, archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive_poster");
        exit();
    }

    $stmt->bind_param("i", $restoreposter_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_poster");
            exit();
        }

        // Extract poster_image for logging
        $poster_image = isset($archive_description['poster_image']) ? $archive_description['poster_image'] : 'Unknown Subject';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_poster");
            exit();
        }

        $types = str_repeat("s", count($values)); 
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
            $stmt = $conn->prepare($deleteQuery);

            if (!$stmt) {
                $_SESSION['toastMsg'] = "Database error (DELETE): " . $conn->error;
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_poster");
                exit();
            }

            $stmt->bind_param("i", $restoreposter_id);
            $stmt->execute();

            // Insert into history_log table
            $logDescription = "Poster Restore: '$poster_image'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "News restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore news: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "News not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_poster");
    exit();
}

// Permanent Delete poster Function
if (isset($_GET['deleteposter_id'])) {
    $record_id = intval($_GET['deleteposter_id']); // Prevent SQL Injection

    // Fetch the deleteposter_id before deleting
    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $poster_image = isset($archive_description['poster_image']) ? $archive_description['poster_image'] : 'Unknown Subject';
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['poster_image'])) {
            $poster_image = $archive_description['poster_image'];
        }
    }

    // Delete the poster_image from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent deleted the poster: '$poster_image'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "Poster permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete poster: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../pages/adminukt/archive_poster");
    exit();
}
// Restore and delete function for PAGE POSTER END


// Restore and delete function for ADMISSION REQUIREMENTS START
if (isset($_GET['restorerequirement_id'])) {
    $restorerequirement_id = intval($_GET['restorerequirement_id']);

    // Select only the archived record for admission_requirement
    $query = "SELECT original_table, archive_description FROM university_archive 
              WHERE record_id = ? AND original_table = 'admission_requirement'";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive_admissionrequirements");
        exit();
    }

    $stmt->bind_param("i", $restorerequirement_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_admissionrequirements");
            exit();
        }

        // Validate foreign key constraints
        if ($original_table === 'admission_requirement') {
            $ap_id = $archive_description['ap_id'];
            $up_id = $archive_description['up_id'];

            $stmt = $conn->prepare("SELECT 1 FROM authorized_person WHERE ap_id = ?");
            $stmt->bind_param("i", $ap_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows === 0) {
                $_SESSION['toastMsg'] = "Restore failed: Authorized person does not exist.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_admissionrequirements");
                exit();
            }

            $stmt = $conn->prepare("SELECT 1 FROM university_profile WHERE up_id = ?");
            $stmt->bind_param("i", $up_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows === 0) {
                $_SESSION['toastMsg'] = "Restore failed: University profile does not exist.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_admissionrequirements");
                exit();
            }
        }

        // Insert record into the original table
        $requirement_title = $archive_description['requirement_title'] ?? 'Unknown Requirement';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        // Determine bind types
        $types = '';
        foreach ($values as $val) {
            if (is_int($val)) $types .= 'i';
            elseif (is_float($val)) $types .= 'd';
            else $types .= 's';
        }

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_admissionrequirements");
            exit();
        }

        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            // Delete from archive
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ? AND original_table = 'admission_requirement'";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $restorerequirement_id);
            $stmt->execute();

            // Log the restoration
            $logDescription = "Restored admission requirement: '$requirement_title'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "Admission requirement restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore Admission requirement: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Admission requirement not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_admissionrequirements");
    exit();
}

// Permanent Delete ADMISSION Function
if (isset($_GET['deleteadrequirement_id'])) {
    $record_id = intval($_GET['deleteadrequirement_id']); // Prevent SQL Injection

    // Fetch the deleteadrequirement_id before deleting
    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $requirement_title = isset($archive_description['requirement_title']) ? $archive_description['requirement_title'] : 'Unknown Subject';
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['requirement_title'])) {
            $requirement_title = $archive_description['requirement_title'];
        }
    }

    // Delete the requirement_title from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent deleted the admission requirement: '$requirement_title'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "Admission requirement permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete admission requirement: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../pages/adminukt/archive_admissionrequirements");
    exit();
}
// Restore and delete function for ADMISSION REQUIREMENTS END


// Restore and delete function for SCHOLARSHIP START
if (isset($_GET['restorescholarship_id'])) {
    $restorescholarship_id = intval($_GET['restorescholarship_id']);

    // Select only the archived record for scholarship
    $query = "SELECT original_table, archive_description FROM university_archive 
          WHERE record_id = ? AND original_table = 'university_scholarship'";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        $_SESSION['toastMsg'] = "Database error: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/archive_scholarship");
        exit();
    }

    $stmt->bind_param("i", $restorescholarship_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    if ($archive) {
        $original_table = $archive['original_table'];
        $archive_description = json_decode($archive['archive_description'], true) ?? [];

        if (!is_array($archive_description) || empty($archive_description)) {
            $_SESSION['toastMsg'] = "Invalid archive data format.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_scholarship");
            exit();
        }

        // Validate foreign key constraints
        if ($original_table === 'university_scholarship') {
            $ap_id = $archive_description['ap_id'];
            $up_id = $archive_description['up_id'];

            $stmt = $conn->prepare("SELECT 1 FROM authorized_person WHERE ap_id = ?");
            $stmt->bind_param("i", $ap_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows === 0) {
                $_SESSION['toastMsg'] = "Restore failed: Authorized person does not exist.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_scholarship");
                exit();
            }

            $stmt = $conn->prepare("SELECT 1 FROM university_profile WHERE up_id = ?");
            $stmt->bind_param("i", $up_id);
            $stmt->execute();
            if ($stmt->get_result()->num_rows === 0) {
                $_SESSION['toastMsg'] = "Restore failed: University profile does not exist.";
                $_SESSION['toastType'] = "toast-error";
                header("Location: ../pages/adminukt/archive_scholarship");
                exit();
            }
        }

        // Insert record into the original table
        $scholarship_title = $archive_description['scholarship_title'] ?? 'Unknown scholarship';

        $columns = implode(", ", array_keys($archive_description));
        $placeholders = implode(", ", array_fill(0, count($archive_description), "?"));
        $values = array_values($archive_description);

        // Determine bind types
        $types = '';
        foreach ($values as $val) {
            if (is_int($val)) $types .= 'i';
            elseif (is_float($val)) $types .= 'd';
            else $types .= 's';
        }

        $restoreQuery = "INSERT INTO `$original_table` ($columns) VALUES ($placeholders)";
        $stmt = $conn->prepare($restoreQuery);

        if (!$stmt) {
            $_SESSION['toastMsg'] = "Database error (INSERT): " . $conn->error;
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../pages/adminukt/archive_scholarship");
            exit();
        }

        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            // Delete from archive
            $deleteQuery = "DELETE FROM university_archive WHERE record_id = ? AND original_table = 'university_scholarship'";
            $stmt = $conn->prepare($deleteQuery);
            $stmt->bind_param("i", $restorescholarship_id);
            $stmt->execute();

            // Log the restoration
            $logDescription = "Restored scholarship: '$scholarship_title'";
            $logDate = date("Y-m-d");
            $logTime = date("H:i:s");

            $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($logQuery);
            $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
            $stmt->execute();

            $_SESSION['toastMsg'] = "Scholarship restored successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Failed to restore Scholarship: " . $stmt->error;
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Scholarship not found in archive.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/archive_scholarship");
    exit();
}

// Permanent Delete  scholarship Function
if (isset($_GET['deletescholarship_id'])) {
    $record_id = intval($_GET['deletescholarship_id']); 

    // Fetch the deletescholarship_id before deleting
    $query = "SELECT archive_description FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $record_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $archive = $result->fetch_assoc();

    $scholarship_title= "Unknown Subject"; // Default if not found
    if ($archive) {
        $archive_description = json_decode($archive['archive_description'], true);
        if (isset($archive_description['scholarship_title'])) {
            $scholarship_title = $archive_description['scholarship_title'];
        }
    }

    // Delete the scholarship from the archive
    $deleteQuery = "DELETE FROM university_archive WHERE record_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $record_id);

    if ($stmt->execute()) {
        // Insert into history_log table
        $logDescription = "Permanent delete the scholarship: '$scholarship_title'";
        $logDate = date("Y-m-d"); 
        $logTime = date("H:i:s"); 

        $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($logQuery);
        $stmt->bind_param("sssi", $logDescription, $logDate, $logTime, $user_id);
        $stmt->execute();

        $_SESSION['toastMsg'] = "Scholarship permanently deleted!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Failed to delete Scholarship: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../pages/adminukt/archive_scholarship");
    exit();
}
// Restore and delete function for SCHOLARSHIP END

?>

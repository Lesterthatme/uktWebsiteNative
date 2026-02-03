<?php
include("../../connection/dbconnection.php"); 
session_start();

date_default_timezone_set("Asia/Phnom_Penh");

// Adding Scholarship start
if (isset($_POST["add_scholarship"])) { 
    $status = "Active";
    $scholarship_title = $_POST["scholarship_title"];
    $description = $_POST["description"];
    $up_id = 1; 
    $date_added = $_POST["date_added"]; 

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];

        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $stmt_ap = $conn->prepare($ap_query);
        $stmt_ap->bind_param("i", $user_id);
        $stmt_ap->execute();
        $result_ap = $stmt_ap->get_result();
        
        if ($result_ap->num_rows > 0) {
            $row = $result_ap->fetch_assoc();
            $ap_id = $row["ap_id"];
        } else {
            $_SESSION['toastMsg'] = "Error: Authorized person not found.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/scholarship");
            exit;
        }
        $stmt_ap->close();
    } else {
        $_SESSION['toastMsg'] = "Error: User not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/scholarship");
        exit;
    }

    $sql = "INSERT INTO university_scholarship (scholarship_title, description, date_added, status, ap_id, up_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $scholarship_title, $description, $date_added, $status, $ap_id, $up_id);

    if ($stmt->execute()) {
        $log_description = "Added a new University Scholarship: " . $scholarship_title;
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        $_SESSION['toastMsg'] = "Scholarship added successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error adding scholarship: " . $stmt->error;
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../pages/content_manager/scholarship");
    exit;
}
// Adding Scholarship End

// Updating Scholarship start
if (isset($_POST['update_scholarship'])) {
    $scholarship_id = $_POST['scholarship_id'];
    $scholarship_title = mysqli_real_escape_string($conn, $_POST['scholarship_title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $date_added = mysqli_real_escape_string($conn, $_POST['date_added']);

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];
    } else {
        $_SESSION['toastMsg'] = "Error: User not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/scholarship");
        exit;
    }

    $query = "UPDATE university_scholarship 
              SET scholarship_title = '$scholarship_title', 
                  description = '$description', 
                  status = '$status',
                  date_added = '$date_added'
              WHERE scholarship_id = '$scholarship_id'";

    if (mysqli_query($conn, $query)) {
        $log_description = "Updated University Scholarship: " . $scholarship_title;
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        $_SESSION['toastMsg'] = "Scholarship updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating scholarship: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
    }

    mysqli_close($conn);
    header("Location: ../../pages/content_manager/scholarship");
    exit;
}
// Updating Scholarship End

// Deleting Scholarship start
if (isset($_GET['scholarship_id'])) {
    $scholarship_id = intval($_GET['scholarship_id']);

    $check_query = "SELECT * FROM university_scholarship WHERE scholarship_id = $scholarship_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result); // Store scholarship data
        $scholarship_title = $row['scholarship_title'];

        // Get user_id from session
        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION["user_id"];
        } else {
            $_SESSION['toastMsg'] = "Error: User not logged in.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/scholarship");
            exit;
        }

        // Get ap_id of current user
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $stmt_ap = $conn->prepare($ap_query);
        $stmt_ap->bind_param("i", $user_id);
        $stmt_ap->execute();
        $stmt_ap->bind_result($ap_id);
        $stmt_ap->fetch();
        $stmt_ap->close();

        // Insert into archive table before deletion
        $original_table = "university_scholarship";
        $record_id = $scholarship_id;
        $archive_description = json_encode($row); // convert full row to JSON
        $archived_at = date("Y-m-d H:i:s");
        $up_id = 1;

        $archive_sql = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id)
                        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_archive = $conn->prepare($archive_sql);
        $stmt_archive->bind_param("sissii", $original_table, $record_id, $archive_description, $archived_at, $ap_id, $up_id);
        $stmt_archive->execute();
        $stmt_archive->close();

        // Now delete the scholarship
        $delete_query = "DELETE FROM university_scholarship WHERE scholarship_id = $scholarship_id";
        if (mysqli_query($conn, $delete_query)) {
            // Insert into history log
            $log_description = "Deleted Scholarship: " . $scholarship_title;
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt_log = $conn->prepare($log_sql);
            $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
            $stmt_log->execute();
            $stmt_log->close();

            $_SESSION['toastMsg'] = "Scholarship deleted and archived successfully.";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error deleting scholarship.";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Scholarship not found.";
        $_SESSION['toastType'] = "toast-error";
    }
    header("Location: ../../pages/content_manager/scholarship");
    exit;
}
// Deleting Scholarship End

?>

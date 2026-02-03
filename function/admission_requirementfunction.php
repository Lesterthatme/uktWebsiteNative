<?php
include("../connection/dbconnection.php"); 
session_start();

date_default_timezone_set("Asia/Phnom_Penh");

// Start adding requirement
if (isset($_POST["add_requirement"])) { 
    $status = 'Active';
    $requirement_title = $_POST["requirement_title"];
    $description = $_POST["description"];
    $up_id = 1; 
    $date_added = $_POST["date_added"]; 

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];

        // Fetch authorized person ID from user_account table
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
            header("Location: ../pages/adminukt/admission_requirements");
            exit;
        }
        $stmt_ap->close();
    } else {
        $_SESSION['toastMsg'] = "Error: User not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/admission_requirements");
        exit;
    }

    // Insert into admission_requirement table
    $sql = "INSERT INTO admission_requirement (requirement_title, description, date_added, status, ap_id, up_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $requirement_title, $description, $date_added, $status, $ap_id, $up_id);

    if ($stmt->execute()) {
        // Insert log into history_log table
        $log_description = "Added a new admission requirement: " . $requirement_title;
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        $_SESSION['toastMsg'] = "Requirement added successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error adding requirement.";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../pages/adminukt/admission_requirements");
    exit();
}
// End adding requirement

// Start updating requirement
if (isset($_POST['update_requirement'])) {
    $requirement_id = $_POST['requirement_id'];
    $requirement_title = mysqli_real_escape_string($conn, $_POST['requirement_title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $date_added = mysqli_real_escape_string($conn, $_POST['date_added']);

    if (!isset($_SESSION["user_id"])) {
        $_SESSION['toastMsg'] = "Error: User not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/admission_requirements");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $query = "UPDATE admission_requirement 
              SET requirement_title = '$requirement_title', 
                  description = '$description', 
                  status = '$status',
                  date_added = '$date_added' 
              WHERE requirement_id = '$requirement_id'";

    if (mysqli_query($conn, $query)) {
        $log_description = "Updated admission requirement: " . $requirement_title;
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        $_SESSION['toastMsg'] = "Requirement updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating requirement: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
    }

    mysqli_close($conn);
    header("Location: ../pages/adminukt/admission_requirements");
    exit();
}
// End updating requirement

// Start deleting requirement
if (isset($_GET['requirement_id'])) {
    $requirement_id = intval($_GET['requirement_id']);

    // Make sure the user is logged in
    if (!isset($_SESSION["user_id"])) {
        $_SESSION['toastMsg'] = "Error: User not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/admission_requirements");
        exit();
    }

    $user_id = $_SESSION["user_id"];

    // Get authorized person (ap_id) using user_id
    $stmt_ap = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
    $stmt_ap->bind_param("i", $user_id);
    $stmt_ap->execute();
    $result_ap = $stmt_ap->get_result();

    if ($result_ap->num_rows === 0) {
        $_SESSION['toastMsg'] = "Error: Authorized person not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/admission_requirements");
        exit();
    }

    $ap_row = $result_ap->fetch_assoc();
    $archived_by = $ap_row['ap_id'];
    $up_id = 1; // constant

    $stmt_ap->close();

    // Check if requirement exists
    $check_query = "SELECT * FROM admission_requirement WHERE requirement_id = $requirement_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $row = mysqli_fetch_assoc($check_result);
        $requirement_title = $row['requirement_title'];

        // Archive the record before deletion
        $archive_description = json_encode($row, JSON_UNESCAPED_UNICODE);

        $archive_stmt = $conn->prepare("INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id)
                                        VALUES (?, ?, ?, NOW(), ?, ?)");
        $original_table = 'admission_requirement';
        $archive_stmt->bind_param("sisii", $original_table, $requirement_id, $archive_description, $archived_by, $up_id);
        $archive_stmt->execute();
        $archive_stmt->close();

        // Delete the requirement
        $delete_query = "DELETE FROM admission_requirement WHERE requirement_id = $requirement_id";
        if (mysqli_query($conn, $delete_query)) {
            // Insert log
            $log_description = "Deleted admission requirement: " . $requirement_title;
            $log_date = date("Y-m-d");
            $log_time = date("H:i:s");

            $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
            $stmt_log = $conn->prepare($log_sql);
            $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
            $stmt_log->execute();
            $stmt_log->close();

            $_SESSION['toastMsg'] = "Requirement deleted and archived successfully.";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error deleting requirement.";
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "Requirement not found.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/admission_requirements");
    exit();
}
// End deleting requirement

?>
<?php
include("../connection/dbconnection.php"); 
session_start();

date_default_timezone_set("Asia/Phnom_Penh");

// start adding program function
if (isset($_POST["add_program"])) { 
    $status = $_POST["status"];
    $program_name = $_POST["program_name"];
    $program_description = $_POST["program_description"];
    $course_code = $_POST["course_code"];
    $course_duration = $_POST["course_duration"];
    $date_created = date("Y-m-d"); 
    $department_id = isset($_POST["department_id"]) ? intval($_POST["department_id"]) : null;

    if (!$department_id) {
        $_SESSION['toastMsg'] = 'Error: Department ID not found.';
        $_SESSION['toastType'] = 'toast-error';
        header("Location: ../pages/adminukt/manage_program");
        exit;
    }

    // Check if department exists
    $check_department = "SELECT department_id FROM department WHERE department_id = ?";
    $stmt_check = $conn->prepare($check_department);
    $stmt_check->bind_param("i", $department_id);
    $stmt_check->execute();
    $result_department = $stmt_check->get_result();

    if ($result_department->num_rows == 0) {
        $_SESSION['toastMsg'] = 'Error: Invalid department ID.';
        $_SESSION['toastType'] = 'toast-error';
        header("Location: ../pages/adminukt/manage_program");
        exit;
    }
    $stmt_check->close();

    if (isset($_SESSION["user_id"])) {
        $user_id = $_SESSION["user_id"];

        // Fetch authorized person ID
        $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
        $stmt_ap = $conn->prepare($ap_query);
        $stmt_ap->bind_param("i", $user_id);
        $stmt_ap->execute();
        $result_ap = $stmt_ap->get_result();
        
        if ($result_ap->num_rows > 0) {
            $row = $result_ap->fetch_assoc();
            $ap_id = $row["ap_id"];
        } else {
            $_SESSION['toastMsg'] = 'Error: Authorized person not found.';
            $_SESSION['toastType'] = 'toast-error';
            header("Location: ../pages/adminukt/manage_program");
            exit;
        }
        $stmt_ap->close();
    } else {
        $_SESSION['toastMsg'] = 'Error: User not logged in.';
        $_SESSION['toastType'] = 'toast-error';
        header("Location: ../pages/adminukt/manage_program");
        exit;
    }

    $sql = "INSERT INTO program_offering (program_name, course_code, course_duration, program_description, date_created, status, department_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $program_name, $course_code, $course_duration, $program_description, $date_created, $status, $department_id);

    if ($stmt->execute()) {
        // Insert log into history_log table
        $log_description = "Added a new program: " . $program_name;
        $log_date = date("Y-m-d");  
        $log_time = date("H:i:s");

        $log_sql = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
        $stmt_log = $conn->prepare($log_sql);
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        $_SESSION['toastMsg'] = 'Program added successfully!';
        $_SESSION['toastType'] = 'toast-success';
        header("Location: ../pages/adminukt/manage_program?department_id={$department_id}");
    } else {
        $_SESSION['toastMsg'] = 'Error adding program.';
        $_SESSION['toastType'] = 'toast-error';
        header("Location: ../pages/adminukt/manage_program");
    }

    $stmt->close();
    $conn->close();
}
// End adding program function
?>

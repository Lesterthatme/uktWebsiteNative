<?php
include("../../connection/dbconnection.php"); 
session_start();

date_default_timezone_set("Asia/Phnom_Penh");

// ADD PROGRAM start
if (isset($_POST["add_program"])) {
    $status = $_POST["status"];
    $program_name = $_POST["program_name"];
    $program_description = $_POST["program_description"];
    $course_code = $_POST["course_code"];
    $course_duration = $_POST["course_duration"];
    $date_created = date("Y-m-d");
    $department_id = isset($_POST["department_id"]) ? intval($_POST["department_id"]) : null;

    if (!$department_id) {
        $_SESSION['toastMsg'] = "Error: Department ID not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/manage_program");
        exit;
    }

    // Validate department
    $stmt_check = $conn->prepare("SELECT department_id FROM department WHERE department_id = ?");
    $stmt_check->bind_param("i", $department_id);
    $stmt_check->execute();
    $result_department = $stmt_check->get_result();
    $stmt_check->close();

    if ($result_department->num_rows == 0) {
        $_SESSION['toastMsg'] = "Error: Invalid department ID.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/manage_program");
        exit;
    }

    // Get user and authorized person
    if (!isset($_SESSION["user_id"])) {
        $_SESSION['toastMsg'] = "Error: User not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/manage_program");
        exit;
    }

    $user_id = $_SESSION["user_id"];
    $stmt_ap = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
    $stmt_ap->bind_param("i", $user_id);
    $stmt_ap->execute();
    $result_ap = $stmt_ap->get_result();
    $stmt_ap->close();

    if ($result_ap->num_rows == 0) {
        $_SESSION['toastMsg'] = "Error: Authorized person not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/manage_program");
        exit;
    }

    // Insert program
    $stmt = $conn->prepare("INSERT INTO program_offering (program_name, course_code, course_duration, program_description, date_created, status, department_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $program_name, $course_code, $course_duration, $program_description, $date_created, $status, $department_id);

    if ($stmt->execute()) {
        $log_description = "Added a new program: $program_name";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $stmt_log = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)");
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        $_SESSION['toastMsg'] = "Program Added Successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error adding program.";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../pages/content_manager/manage_program?department_id=$department_id");
    exit;
}
// ADD PROGRAM end

// UPDATE PROGRAM start
if (isset($_POST['update_program'])) {
    $program_id = intval($_POST['program_id']);
    $department_id = intval($_POST['department_id']);
    $program_name = $_POST['program_name'];
    $course_code = $_POST['course_code'];
    $course_duration = $_POST['course_duration'];
    $program_description = $_POST['program_description'];
    $status = $_POST['status'];
    $date_created = date("Y-m-d", strtotime($_POST['date_created']));

    if (!isset($_SESSION["user_id"])) {
        $_SESSION['toastMsg'] = "Error: User not logged in.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/manage_program");
        exit;
    }

    $user_id = $_SESSION["user_id"];

    $stmt = $conn->prepare("UPDATE program_offering SET program_name = ?, course_code = ?, course_duration = ?, program_description = ?, status = ?, date_created = ? WHERE program_id = ?");
    $stmt->bind_param("ssssssi", $program_name, $course_code, $course_duration, $program_description, $status, $date_created, $program_id);

    if ($stmt->execute()) {
        $log_description = "Updated Course Program: $program_name";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $stmt_log = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)");
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        $_SESSION['toastMsg'] = "Program Updated Successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating program.";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../../pages/content_manager/manage_program?department_id=$department_id");
    exit;
}
// UPDATE PROGRAM end

// DELETE PROGRAM start
if (isset($_GET['program_id'])) {
    $program_id = intval($_GET['program_id']);
    $stmt = $conn->prepare("SELECT program_name, department_id FROM program_offering WHERE program_id = ?");
    $stmt->bind_param("i", $program_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $_SESSION['toastMsg'] = "Program not found.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../../pages/content_manager/manage_program");
        exit;
    }

    $program = $result->fetch_assoc();
    $program_name = $program['program_name'];
    $department_id = $program['department_id'];
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM program_offering WHERE program_id = ?");
    $stmt->bind_param("i", $program_id);
    
    if ($stmt->execute()) {
        if (!isset($_SESSION["user_id"])) {
            $_SESSION['toastMsg'] = "Error: User not logged in.";
            $_SESSION['toastType'] = "toast-error";
            header("Location: ../../pages/content_manager/manage_program");
            exit;
        }

        $user_id = $_SESSION["user_id"];
        $log_description = "Deleted Program: $program_name";
        $log_date = date("Y-m-d");
        $log_time = date("H:i:s");

        $stmt_log = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)");
        $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
        $stmt_log->execute();
        $stmt_log->close();

        $_SESSION['toastMsg'] = "Program Deleted Successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error deleting program.";
        $_SESSION['toastType'] = "toast-error";
    }

    $stmt->close();
    header("Location: ../../pages/content_manager/manage_program?department_id=$department_id");
    exit;
}
// DELETE PROGRAM start
?>

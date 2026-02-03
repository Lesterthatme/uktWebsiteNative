<?php
session_start();
include '../../../connection/dbconnection.php';

date_default_timezone_set('Asia/Phnom_Penh');

// Toast function
function setToastMessage($message, $type = "toast-success") {
    $_SESSION['toastMsg'] = $message;
    $_SESSION['toastType'] = $type;
}

// update mission function start
if (isset($_POST['update_mission'])) {
    $library_mission = mysqli_real_escape_string($conn, $_POST['library_mission']);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    $query = "UPDATE library_university SET library_mission = '$library_mission' WHERE library_id = 1";
    
    if (mysqli_query($conn, $query)) {
        $description = "University Library Mission Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        setToastMessage("Updated successfully.");
        header("Location: ../library_vmgo");
        exit();
    } else {
        setToastMessage("Error updating mission: " . mysqli_error($conn), "toast-error");
        header("Location: ../library_vmgo");
        exit();
    }
}
// update mission function end

// update vision function start
if (isset($_POST['update_vision'])) {
    $library_vision = mysqli_real_escape_string($conn, $_POST['library_vision']);
    $user_id = $_SESSION['user_id']; 

    $query = "UPDATE library_university SET library_vision = '$library_vision' WHERE library_id = 1";
    if (mysqli_query($conn, $query)) {
        $description = "University Library Vision Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        setToastMessage("Updated successfully.");
        header("Location: ../library_vmgo");
        exit();
    } else {
        setToastMessage("Error updating vision: " . mysqli_error($conn), "toast-error");
        header("Location: ../library_vmgo");
        exit();
    }
}
// update vision function end

// update goal function start
if (isset($_POST['update_goal'])) {
    $library_goal = mysqli_real_escape_string($conn, $_POST['library_goal']);
    $user_id = $_SESSION['user_id']; 

    $query = "UPDATE library_university SET library_goal = '$library_goal' WHERE library_id = 1";
    
    if (mysqli_query($conn, $query)) {
        $description = "University Library Goal Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        setToastMessage("Updated successfully.");
        header("Location: ../library_vmgo");
        exit();
    } else {
        setToastMessage("Error updating goal: " . mysqli_error($conn), "toast-error");
        header("Location: ../library_vmgo");
        exit();
    }
}
// update goal function end

// update objectives function start
if (isset($_POST['update_objectives'])) {
    $library_objectives = mysqli_real_escape_string($conn, $_POST['library_objectives']);
    $user_id = $_SESSION['user_id']; 

    $query = "UPDATE library_university SET library_objectives = '$library_objectives' WHERE library_id = 1";
    
    if (mysqli_query($conn, $query)) {
        $description = "University Library Objectives Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        setToastMessage("Updated successfully.");
        header("Location: ../library_vmgo");
        exit();
    } else {
        setToastMessage("Error updating objectives: " . mysqli_error($conn), "toast-error");
        header("Location: ../library_vmgo");
        exit();
    }
}
// update objectives function end
?>

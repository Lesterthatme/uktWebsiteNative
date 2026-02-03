<?php
session_start();
include '../../connection/dbconnection.php';

date_default_timezone_set('Asia/Phnom_Penh');


if (isset($_POST['update_mission'])) {
    $university_mission = mysqli_real_escape_string($conn, $_POST['university_mission']);
    $user_id = $_SESSION['user_id']; 

    $query = "UPDATE university_vmgo SET university_mission = '$university_mission' WHERE vmgo_id = 1";
    
    if (mysqli_query($conn, $query)) {

        $description = "University Mission Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);


        $_SESSION['toastMsg'] = "University mission updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {

        $_SESSION['toastMsg'] = "Error updating mission: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
    }
    header("Location: ../../pages/content_manager/university_vmgo");
    exit();
}

// Update Vision
if (isset($_POST['update_vision'])) {
    $university_vision = mysqli_real_escape_string($conn, $_POST['university_vision']);
    $user_id = $_SESSION['user_id']; 

    $query = "UPDATE university_vmgo SET university_vision = '$university_vision' WHERE vmgo_id = 1";
    
    if (mysqli_query($conn, $query)) {

        $description = "University Vision Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);


        $_SESSION['toastMsg'] = "University vision updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {

        $_SESSION['toastMsg'] = "Error updating vision: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../../pages/content_manager/university_vmgo");
    exit();
}

// Update Goal
if (isset($_POST['update_goal'])) {
    $university_goal = mysqli_real_escape_string($conn, $_POST['university_goal']);
    $user_id = $_SESSION['user_id']; 

    $query = "UPDATE university_vmgo SET university_goal = '$university_goal' WHERE vmgo_id = 1";
    
    if (mysqli_query($conn, $query)) {

        $description = "University Goal Updated.";
        $log_date = date('Y-m-d'); 
        $log_time = date('H:i:s');
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        $_SESSION['toastMsg'] = "University goal updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating goal: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
    }
    header("Location: ../../pages/content_manager/university_vmgo");
    exit();
}
?>

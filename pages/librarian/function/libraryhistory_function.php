<?php
include '../../../connection/dbconnection.php';
session_start();
date_default_timezone_set('Asia/Phnom_Penh');


if (isset($_POST['library_history'])) {
    $library_history = mysqli_real_escape_string($conn, $_POST['library_history']);
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE library_university SET library_history = '$library_history' WHERE library_id = 1";

    if (mysqli_query($conn, $query)) {
        $description = "Library University History Updated.";
        $log_date = date('Y-m-d');
        $log_time = date('H:i:s');

        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        // Set Toast Message
        $_SESSION['toastMsg'] = "Library History updated successfully.";
        $_SESSION['toastType'] = "toast-success";

        header("Location: ../library_history.php?update=success");
        exit();
    } else {
        // Error Handling
        $_SESSION['toastMsg'] = "Error updating record: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";

        header("Location: ../library_history.php");
        exit();
    }
}

<?php
include '../../connection/dbconnection.php';
session_start();
date_default_timezone_set('Asia/Phnom_Penh');

if (isset($_POST['update_hymn'])) {
    $hymn_author = mysqli_real_escape_string($conn, $_POST['hymn_author']);
    $hymn_title = mysqli_real_escape_string($conn, $_POST['hymn_title']);
    $hymn_lyrics = mysqli_real_escape_string($conn, $_POST['hymn_lyrics']);
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE university_hymn SET hymn_author = '$hymn_author', hymn_title = '$hymn_title',
              hymn_lyrics = '$hymn_lyrics' WHERE hymn_id = 1";

    if (mysqli_query($conn, $query)) {

        $description = "University Hymn Updated.";
        $log_date = date('Y-m-d');
        $log_time = date('H:i:s');
        $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$description', '$log_date', '$log_time', '$user_id')";
        mysqli_query($conn, $log_query);

        $_SESSION['toastMsg'] = "University hymn updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating hymn: " . mysqli_error($conn);
        $_SESSION['toastType'] = "toast-error";
    }
    header("Location: ../../pages/content_manager/university_hymn");
    exit();
}
?>

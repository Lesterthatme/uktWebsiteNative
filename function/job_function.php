<?php
include '../connection/dbconnection.php';
session_start();
date_default_timezone_set('Asia/Phnom_Penh');

if (isset($_POST['update_job'])) {
    $job_description = mysqli_real_escape_string($conn, $_POST['job_description']);
    $posted_date = mysqli_real_escape_string($conn, $_POST['posted_date']);
    $application_deadline = mysqli_real_escape_string($conn, $_POST['application_deadline']);
    $contact_email = mysqli_real_escape_string($conn, $_POST['contact_email']);
    $user_id = $_SESSION['user_id'];

    $get_ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = '$user_id' LIMIT 1";
    $ap_result = mysqli_query($conn, $get_ap_query);

    if ($ap_result && mysqli_num_rows($ap_result) > 0) {
        $ap_row = mysqli_fetch_assoc($ap_result);
        $ap_id = $ap_row['ap_id'];
        $query = "UPDATE job_opportunities 
                  SET job_description = '$job_description', posted_date = '$posted_date', application_deadline = '$application_deadline', 
                      contact_email = '$contact_email', ap_id = '$ap_id' WHERE up_id = 1";

        if (mysqli_query($conn, $query)) {
            $description = "Job Updated.";
            $log_date = date('Y-m-d');
            $log_time = date('H:i:s');
            $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) 
                          VALUES ('$description', '$log_date', '$log_time', '$user_id')";
            mysqli_query($conn, $log_query);

            $_SESSION['toastMsg'] = "Job opportunity updated successfully!";
            $_SESSION['toastType'] = "toast-success";
        } else {
            $_SESSION['toastMsg'] = "Error updating record: " . mysqli_error($conn);
            $_SESSION['toastType'] = "toast-error";
        }
    } else {
        $_SESSION['toastMsg'] = "No authorized person found for this user.";
        $_SESSION['toastType'] = "toast-error";
    }

    header("Location: ../pages/adminukt/job_opportunities");
    exit();
}
?>

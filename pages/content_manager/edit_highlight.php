<?php
require '../../connection/dbconnection.php';
session_start();

if (!isset($_SESSION['session_token'])) {
    header('location:login.php');
    exit;
}

// Fetch highlight data
$highlight = [];
if (isset($_GET['h_id'])) {
    $h_id = intval($_GET['h_id']);
    $result = $conn->query("SELECT * FROM highlight WHERE h_id = $h_id");
    $highlight = $result->fetch_assoc();
}

// Update highlight
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $h_id = intval($_POST['h_id']);
    $h_icon = $_POST['h_icon'];
    $h_title = $_POST['h_title'];
    $h_description = $_POST['h_description'];

    if ($conn->query("UPDATE highlight SET h_icon='$h_icon', h_title='$h_title', h_description='$h_description' WHERE h_id=$h_id")) {
        // Log action
        $user_id = $_SESSION['user_id'];
        $log_description = "You updated the highlight: $h_title";
        date_default_timezone_set('Asia/Phnom_Penh');
        
        $conn->query("INSERT INTO history_log (description, log_date, log_time, user_id) 
                      VALUES ('$log_description', CURDATE(), CURTIME(), $user_id)");

        $_SESSION['toastMsg'] = "Highlight updated successfully!";
        $_SESSION['toastType'] = "toast-success";
    } else {
        $_SESSION['toastMsg'] = "Error updating highlight: " . $conn->error;
        $_SESSION['toastType'] = "toast-error";
    }
    header("Location: ../content_manager/page_management");
    exit();
}
?>

<?php
header("Content-Type: application/json");
include '../../connection/dbconnection.php';
session_start();

if (!isset($_SESSION['session_token']) || !isset($_SESSION['user_id'])) {
    $_SESSION['toastMsg'] = "Unauthorized access. Please log in again.";
    $_SESSION['toastType'] = "toast-error";
    echo json_encode(["status" => "error", "message" => $_SESSION['toastMsg']]);
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT ap_id FROM authorized_person WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    $_SESSION['toastMsg'] = "Authorized person not found.";
    $_SESSION['toastType'] = "toast-error";
    echo json_encode(["status" => "error", "message" => $_SESSION['toastMsg']]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

$library_id = 1;

// Assuming your actual table is named `operating_hours`
foreach ($data["schedule"] as $schedule) {
    $day = mysqli_real_escape_string($conn, $schedule["day"]);
    $is_open = (int)$schedule["is_open"];
    $open_time = mysqli_real_escape_string($conn, $schedule["open_time"]);
    $close_time = mysqli_real_escape_string($conn, $schedule["close_time"]);

    $sql = "INSERT INTO operating_hours (library_id, day, is_open, open_time, close_time)
            VALUES ('$library_id', '$day', '$is_open', '$open_time', '$close_time')
            ON DUPLICATE KEY UPDATE 
            is_open = VALUES(is_open),
            open_time = VALUES(open_time),
            close_time = VALUES(close_time)";

    if (!mysqli_query($conn, $sql)) {
        $_SESSION['toastMsg'] = "Failed to save schedule for $day.";
        $_SESSION['toastType'] = "toast-error";
        echo json_encode(["status" => "error", "message" => $_SESSION['toastMsg']]);
        exit();
    }
}

$_SESSION['toastMsg'] = "Schedule saved successfully.";
$_SESSION['toastType'] = "toast-success";
echo json_encode(["status" => "success", "message" => $_SESSION['toastMsg']]);
?>

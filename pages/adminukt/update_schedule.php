<?php
include '../../connection/dbconnection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not authenticated"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get ap_id from authorized_person table
$query = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Authorized person not found"]);
    exit;
}

$row = $result->fetch_assoc();
$ap_id = $row['ap_id'];  // Retrieved ap_id

// Get POST data
if (!isset($_POST['oh_id']) || !isset($_POST['is_open'])) {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}
$oh_id = intval($_POST['oh_id']); // Ensure it's an integer
$is_open = intval($_POST['is_open']);

// Update the database
$stmt = $conn->prepare("UPDATE operating_hours SET is_open = ?, ap_id = ? WHERE oh_id = ?");
$stmt->bind_param("iii", $is_open, $ap_id, $oh_id);
if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Schedule updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update schedule"]);
}

$stmt->close();
$conn->close();
?>  , here is the save_schedule.php code , <?php
header("Content-Type: application/json");
include '../../connection/dbconnection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not authenticated"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch ap_id using user_id
$query = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Authorized person not found"]);
    exit;
}

$row = $result->fetch_assoc();

// Assuming library_id is stored in session or another way
$library_id = $_SESSION['library_id'] ?? 1;  // Replace with actual method to get library_id

$data = json_decode(file_get_contents("php://input"), true);

$stmt = $conn->prepare("INSERT INTO operating_hours (day, is_open, open_time, close_time, ap_id, library_id) 
    VALUES (?, ?, ?, ?, ?, ?) 
    ON DUPLICATE KEY UPDATE is_open = VALUES(is_open), open_time = VALUES(open_time), close_time = VALUES(close_time)");

foreach ($data["schedule"] as $schedule) {
    $stmt->bind_param("sissii", $schedule["day"], $schedule["is_open"], $schedule["open_time"], $schedule["close_time"], $ap_id, $library_id);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(["success" => true, "message" => "Schedule saved successfully"]);
?>
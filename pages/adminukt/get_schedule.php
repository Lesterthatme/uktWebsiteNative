<?php
header("Content-Type: application/json");
include '../../connection/dbconnection.php';
$result = $conn->query("SELECT * FROM operating_hours");
$schedule = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
echo json_encode(["success" => true, "schedule" => $schedule]);
?>
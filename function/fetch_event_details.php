<?php
include '../connection/dbconnection.php'; // Ensure database connection

$response = ['success' => false, 'data' => []];

if (isset($_GET['uc_id'])) {
  $uc_id = $_GET['uc_id'];

  $query = "SELECT * FROM university_calendar WHERE uc_id = ?";
  $stmt = $conn->prepare($query);
  if (!$stmt) {
      die("Prepare failed: " . $conn->error);
  }
  $stmt->bind_param("i", $uc_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    $response['success'] = true;
    $response['data'] = $event;
  } else {
    $response['success'] = false;
    $response['message'] = 'No event found.';
  }
}

header('Content-Type: application/json');
echo json_encode($response);

?>

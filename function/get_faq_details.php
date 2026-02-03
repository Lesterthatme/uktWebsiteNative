<?php
include '../connection/dbconnection.php';

if (isset($_GET['id'])) {
  $faqId = $_GET['id'];
  $sql = "SELECT * FROM faq WHERE faq_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $faqId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
  } else {
    echo json_encode(['error' => 'FAQ not found']);
  }
} else {
  echo json_encode(['error' => 'Invalid request']);
}
?>

<?php
session_start();
include '../connection/dbconnection.php';

// Set Cambodia time zone
date_default_timezone_set('Asia/Phnom_Penh');

// Deny Account Start
if (isset($_GET['user_id']) && isset($_SESSION['user_id'])) {
  $denied_user_id = intval($_GET['user_id']);
  $admin_user_id = intval($_SESSION['user_id']);

  $username_query = "SELECT username FROM user_account WHERE user_id = ?";
  $username_stmt = $conn->prepare($username_query);
  $username_stmt->bind_param("i", $denied_user_id);
  $username_stmt->execute();
  $username_result = $username_stmt->get_result();
  $username_row = $username_result->fetch_assoc();
  $denied_username = $username_row['username'] ?? 'Unknown';
  $username_stmt->close();

  $query = "UPDATE user_account SET account_status = 'denied' WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $denied_user_id);

  if ($stmt->execute()) {
      $description = "Denied the registration of username $denied_username.";
      $log_date = date('Y-m-d');
      $log_time = date('H:i:s');

      $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
      $log_stmt = $conn->prepare($log_query);
      $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $admin_user_id);
      $log_stmt->execute();
      $log_stmt->close();

      // Toast Success Alert
      $_SESSION['toastMsg'] = "User denied successfully.";
      $_SESSION['toastType'] = "toast-success";
  } else {
      // Toast Error Alert
      $_SESSION['toastMsg'] = "User denial was not successful.";
      $_SESSION['toastType'] = "toast-error";
  }

  $stmt->close();
  $conn->close();

  header("Location: ../pages/adminukt/pending_account");
  exit();
} else {
  header("Location: ../pages/adminukt/pending_account");
  exit();
}
// Deny Account End

?>
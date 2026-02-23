<?php
session_start();
include '../connection/dbconnection.php';

// Set Cambodia time zone

// Deny Account Start
if (isset($_GET['user_id'])) {
  $conn->begin_transaction();
  try {
    $denied_user_id = intval($_GET['user_id']);
    $admin_user_id = intval($_SESSION['user_id']);

    $username_query = "SELECT username FROM user_account WHERE user_id = ?";
    $username_stmt = $conn->prepare($username_query);
    $username_stmt->bind_param("i", $denied_user_id);
    $username_stmt->execute();
    $username_result = $username_stmt->get_result();

    if ($username_result->num_rows > 0) {
      $username_row = $username_result->fetch_assoc();
      $denied_username = $username_row['username'];

      $query = "UPDATE user_account SET account_status = 'denied' WHERE user_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $denied_user_id);

      if (!$stmt->execute()) {
        // Toast Error Alert
        $conn->rollback();
        $_SESSION['toastMsg'] = "User denial was not successful.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/pending_account");
        exit;
      }

      $description = "Denied the registration of username $denied_username.";
      $log_date = date('Y-m-d');
      $log_time = date('H:i:s');

      $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
      $log_stmt = $conn->prepare($log_query);
      $log_stmt->bind_param("sssi", $description, $log_date, $log_time, $admin_user_id);
      if (!$log_stmt->execute()) {
        $conn->rollback();
        $_SESSION['toastMsg'] = "Log Error.";
        $_SESSION['toastType'] = "toast-error";
        header("Location: ../pages/adminukt/pending_account");
        exit;
      }

      // Toast Success Alert
      $conn->commit();
      $_SESSION['toastMsg'] = "User denied successfully.";
      $_SESSION['toastType'] = "toast-success";
      header("Location: ../pages/adminukt/pending_account");
      exit();
    } else {
      $_SESSION['toastMsg'] = "No User Found.";
      $_SESSION['toastType'] = "toast-error";
      header("Location: ../pages/adminukt/pending_account");
      exit;
    }
  } catch (Exception $e) {
    $conn->rollback();
    $_SESSION['toastMsg'] = "Something Went Wrong.";
    $_SESSION['toastType'] = "toast-error";
    header("Location: ../pages/adminukt/pending_account");
    exit;
  }
} else {
  header("Location: ../pages/adminukt/pending_account");
  exit();
}
// Deny Account End

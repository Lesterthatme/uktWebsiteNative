<?php
session_start();
include '../../connection/dbconnection.php';
date_default_timezone_set('Asia/Phnom_Penh');

// INSERT FAQ FUNCTION START
if (isset($_POST['add_faq'])) {
  $faq_question = $_POST['faq_question'] ?? null;
  $faq_answer = $_POST['faq_answer'] ?? null;
  $user_id = $_SESSION['user_id'] ?? null;

  $faq_status = "Active";

  if ($faq_question && $faq_answer && $user_id) {

    // Get ap_id from authorized_person
    $ap_stmt = $conn->prepare("SELECT ap_id FROM authorized_person WHERE user_id = ?");
    $ap_stmt->bind_param("i", $user_id);
    $ap_stmt->execute();
    $ap_stmt->bind_result($ap_id);
    $ap_stmt->fetch();
    $ap_stmt->close();

    if ($ap_id) {
      $query = "INSERT INTO faq (faq_question, faq_answer, faq_status, faq_date, faq_time, ap_id) 
                VALUES (?, ?, ?, CURDATE(), CURRENT_TIME(), ?)";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("sssi", $faq_question, $faq_answer, $faq_status, $ap_id);

      if ($stmt->execute()) {
        // Insert log
        $log_description = "Added a new FAQ: '$faq_question' with status '$faq_status'";
        $current_time = date("H:i:s");

        $log_stmt = $conn->prepare("INSERT INTO history_log (description, log_date, log_time, user_id) 
                                    VALUES (?, CURDATE(), ?, ?)");
        $log_stmt->bind_param("ssi", $log_description, $current_time, $user_id);
        $log_stmt->execute();
        $log_stmt->close();

        $_SESSION['toastMsg'] = "FAQ added successfully!";
        $_SESSION['toastType'] = "toast-success";
      } else {
        $_SESSION['toastMsg'] = "Error adding FAQ: " . htmlspecialchars($stmt->error);
        $_SESSION['toastType'] = "toast-error";
      }

      $stmt->close();
      header("Location: ../../pages/content_manager/FaQ");
      exit();
    } else {
      $_SESSION['toastMsg'] = "No authorized person found for this user.";
      $_SESSION['toastType'] = "toast-error";
      header("Location: ../../pages/content_manager/FaQ");
      exit();
    }
  } else {
    $_SESSION['toastMsg'] = "All fields are required.";
    $_SESSION['toastType'] = "toast-error";
    header("Location: ../../pages/content_manager/FaQ");
    exit();
  }
}
// INSERT FAQ FUNCTION END

// DELETE FAQ START
if (isset($_GET['faq_function']) && $_GET['faq_function'] === 'true' && isset($_GET['id'])) {
  $faqId = intval($_GET['id']);

  echo "
  <script>
      if (confirm('Do you really want to delete this FAQ?')) {
          window.location.href = 'faq_function.php?confirm=true&id=$faqId';
      } else {
          window.location.href = '../../pages/content_manager/FaQ';
      }
  </script>";
  exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete']) && !empty($_POST['faq_id'])) {

  $faqId = intval($_POST['faq_id']);

  // Ensure user is logged in
  if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
      $_SESSION['toastMsg'] = "Unauthorized action!";
      $_SESSION['toastType'] = "toast-error";
      header("Location: ../../pages/content_manager/FaQ");
      exit();
  }

  $user_id = $_SESSION['user_id'];

  // Retrieve ap_id from authorized_person using user_id
  $ap_id = null;
  $ap_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
  if ($ap_stmt = $conn->prepare($ap_query)) {
      $ap_stmt->bind_param("i", $user_id);
      $ap_stmt->execute();
      $ap_stmt->bind_result($ap_id);
      $ap_stmt->fetch();
      $ap_stmt->close();
  }

  if (!$ap_id) {
      $_SESSION['toastMsg'] = "Unauthorized action! No associated authorized person.";
      $_SESSION['toastType'] = "toast-error";
      header("Location: ../../pages/content_manager/FaQ");
      exit();
  }

  // Fetch all FAQ details before deletion
  $faq_query = "SELECT faq_question, faq_answer, faq_date, faq_time, faq_status, ap_id FROM faq WHERE faq_id = ?";
  if ($faq_stmt = $conn->prepare($faq_query)) {
      $faq_stmt->bind_param("i", $faqId);
      $faq_stmt->execute();
      $faq_stmt->bind_result($faq_question, $faq_answer, $faq_date, $faq_time, $faq_status, $faq_ap_id);

      if (!$faq_stmt->fetch()) {
          $_SESSION['toastMsg'] = "FAQ not found!";
          $_SESSION['toastType'] = "toast-warning";
          $faq_stmt->close();
          header("Location: ../../pages/content_manager/FaQ");
          exit();
      }

      $faq_stmt->close();
  } else {
      $_SESSION['toastMsg'] = "Database error while fetching FAQ!";
      $_SESSION['toastType'] = "toast-error";
      header("Location: ../../pages/content_manager/FaQ");
      exit();
  }

  // Convert data to JSON format for archive
  $archive_description = json_encode([
      "faq_question" => $faq_question,
      "faq_answer" => $faq_answer,
      "faq_date" => $faq_date,
      "faq_time" => $faq_time,
      "faq_status" => $faq_status,
      "ap_id" => $faq_ap_id
  ]);

  // Archive the FAQ before deletion
  $up_id = 1;
  $archive_query = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id) 
                    VALUES ('faq', ?, ?, NOW(), ?, ?)";
  if ($archive_stmt = $conn->prepare($archive_query)) {
      $archive_stmt->bind_param("issi", $faqId, $archive_description, $ap_id, $up_id);
      $archive_stmt->execute();
      $archive_stmt->close();
  } else {
      $_SESSION['toastMsg'] = "Database error: Unable to archive the FAQ!";
      $_SESSION['toastType'] = "toast-error";
      header("Location: ../../pages/content_manager/FaQ");
      exit();
  }

  // Delete the FAQ after successful archiving
  $delete_query = "DELETE FROM faq WHERE faq_id = ?";
  if ($delete_stmt = $conn->prepare($delete_query)) {
      $delete_stmt->bind_param("i", $faqId);
      if ($delete_stmt->execute()) {
          $delete_stmt->close();

          // Log the deletion
          $log_description = "Deleted FAQ: '$faq_question'";
          $current_time = date("H:i:s");

          $log_query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), ?, ?)";
          if ($log_stmt = $conn->prepare($log_query)) {
              $log_stmt->bind_param("ssi", $log_description, $current_time, $user_id);
              $log_stmt->execute();
              $log_stmt->close();
          }

          $_SESSION['toastMsg'] = "FAQ deleted successfully!";
          $_SESSION['toastType'] = "toast-success";
      } else {
          $_SESSION['toastMsg'] = "Error deleting FAQ!";
          $_SESSION['toastType'] = "toast-error";
      }
  } else {
      $_SESSION['toastMsg'] = "Database error: Unable to process request!";
      $_SESSION['toastType'] = "toast-error";
  }

  header("Location: ../../pages/content_manager/FaQ");
  exit();
}
// DELETE FAQ END


// UPDATE FAQ START
if (isset($_POST['edit_faq'])) {

  $faqId = intval($_POST['faq_id']);
  $faqQuestion = mysqli_real_escape_string($conn, $_POST['faq_question'] ?? '');
  $faqAnswer = mysqli_real_escape_string($conn, $_POST['faq_answer'] ?? '');
  $faqStatus = mysqli_real_escape_string($conn, $_POST['faq_status'] ?? '');
  $userId = $_SESSION['user_id'] ?? 0;

  if (!$faqId || !$faqQuestion || !$faqAnswer || !$faqStatus) {
    $_SESSION['toastMsg'] = "Missing or invalid input data.";
    $_SESSION['toastType'] = "toast-error";
    header("Location: ../../pages/content_manager/FaQ");
    exit();
  }


  $result = mysqli_query($conn, "SELECT faq_question, faq_answer, faq_status FROM faq WHERE faq_id = '$faqId'");
  if (!$result || mysqli_num_rows($result) == 0) {
    $_SESSION['toastMsg'] = "FAQ not found.";
    $_SESSION['toastType'] = "toast-error";
    header("Location: ../../pages/content_manager/FaQ");
    exit();
  }
  $currentData = mysqli_fetch_assoc($result);

  $changes = [];
  if ($faqQuestion !== $currentData['faq_question'])
    $changes[] = "Question";
  if ($faqAnswer !== $currentData['faq_answer'])
    $changes[] = "Answer";
  if ($faqStatus !== $currentData['faq_status'])
    $changes[] = "Status";

  if (empty($changes)) {
    $_SESSION['toastMsg'] = "No changes detected.";
    $_SESSION['toastType'] = "toast-warning";
    header("Location: ../../pages/content_manager/FaQ");
    exit();
  }

  $updateQuery = "UPDATE faq SET faq_question = '$faqQuestion', faq_answer = '$faqAnswer', faq_status = '$faqStatus' WHERE faq_id = '$faqId'";
  if (!mysqli_query($conn, $updateQuery)) {
    $_SESSION['toastMsg'] = "Update failed: " . mysqli_error($conn);
    $_SESSION['toastType'] = "toast-error";
    header("Location: ../../pages/content_manager/FaQ");
    exit();
  }

  $description = "Updated FAQ: " . implode(", ", $changes);
  $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES ('$description', NOW(), NOW(), '$userId')";
  mysqli_query($conn, $logQuery);

  mysqli_close($conn);

  $_SESSION['toastMsg'] = "FAQ updated successfully!";
  $_SESSION['toastType'] = "toast-success";
  header("Location: ../../pages/content_manager/FaQ");
  exit();
}
// UPDATE FAQ END

?>
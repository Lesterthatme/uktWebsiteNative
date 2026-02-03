<?php
session_start();
include("../connection/dbconnection.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../mail/Exception.php';
require '../mail/PHPMailer.php';
require '../mail/SMTP.php';

// Set timezone to Cambodia
date_default_timezone_set("Asia/Phnom_Penh");

// Enable MySQLi error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
if (isset($_POST['send_reply'])) { 
   
    $message_id = intval($_POST['message_id']);
    $ap_id = intval($_POST['ap_id']);
    $reply_message = trim($_POST['reply_message']);

    // Check if message_id is valid
    if (empty($message_id)) {
        die("Error: message_id is missing.");
    }

    // Fetch sender_email from university_message
    $query = "SELECT sender_email, message_body FROM university_message WHERE message_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) die("Prepare failed: " . $conn->error);

    $stmt->bind_param("i", $message_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Error: Message ID not found.");
    }

    $row = $result->fetch_assoc();
    $sender_email = $row['sender_email'];
    $original_message = htmlspecialchars($row['message_body']);

    // Check if reply message is not empty
    if (!empty($reply_message)) {
        // Insert reply into message_reply table
        $query = "INSERT INTO message_reply (reply_message, reply_date, message_id, ap_id) VALUES (?, NOW(), ?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) die("Prepare failed: " . $conn->error);

        $stmt->bind_param("sii", $reply_message, $message_id, $ap_id);

        if ($stmt->execute()) {
            // Retrieve user_id from authorized_person table
            $query = "SELECT user_id FROM authorized_person WHERE ap_id = ?";
            $stmt = $conn->prepare($query);
            if (!$stmt) die("Prepare failed: " . $conn->error);

            $stmt->bind_param("i", $ap_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 0) {
                die("Error: Authorized person not found.");
            }

            $ap_row = $result->fetch_assoc();
            $user_id = $ap_row['user_id'];

            // Insert log into history_log table
            $log_description = "Replied $sender_email concern";
            $query = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, CURDATE(), CURTIME(), ?)";
            $stmt = $conn->prepare($query);
            if (!$stmt) die("Prepare failed: " . $conn->error);

            $stmt->bind_param("si", $log_description, $user_id);
            $stmt->execute();

            // Send email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'uktkratie@gmail.com';
                $mail->Password   = 'fgww ccwv zcjb rdzx';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('uktkratie@gmail.com', 'UKT Support');
                $mail->addAddress($sender_email);
                $mail->Subject = "Response from UKT Support Team";
                $mail->isHTML(true);
                $mail->Body = "
                    <html>
                    <head><title>UKT Support Reply</title></head>
                    <body>
                        <p>Dear User,</p>
                        <p>Good day! Thank you for reaching out. Below is our response to your message:</p>
                        <p style='background-color:#f9f9f9;padding:10px;border-left:3px solid #ccc;'>{$original_message}</p>
                        <p><strong>Our Response:</strong></p>
                        <blockquote style='background-color:#f9f9f9;padding:10px;border-left:3px solid #ccc;'>{$reply_message}</blockquote>
                        <p>Best regards,<br><strong>UKT Support Team</strong></p>
                    </body>
                    </html>
                ";

                if ($mail->send()) {
                    echo "<script>alert('Reply sent successfully!'); window.location.href='../pages/adminukt/view_message?message_id=$message_id';</script>";
                } else {
                    echo "<script>alert('Reply saved but email sending failed.'); window.location.href='../pages/adminukt/view_message?message_id=$message_id';</script>";
                }
            } catch (Exception $e) {
                echo "<script>alert('Reply saved but email error: {$mail->ErrorInfo}'); window.location.href='../pages/adminukt/view_message?message_id=$message_id';</script>";
            }
        } else {
            echo "<script>alert('Error saving reply.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Reply cannot be empty.'); window.history.back();</script>";
    }
}

// delete message start
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['message_ids'])) {

        $message_ids = $_POST['message_ids'];

        if (is_array($message_ids)) {
            $ids = implode(",", array_map('intval', $message_ids)); 

            if (!isset($_SESSION['user_id'])) {
                echo "Error: Session expired. Please log in again.";
                exit();
            }

            $user_id = $_SESSION['user_id'];

            $auth_query = "SELECT ap_id FROM authorized_person WHERE user_id = ?";
            $auth_stmt = $conn->prepare($auth_query);
            $auth_stmt->bind_param("i", $user_id);
            $auth_stmt->execute();
            $auth_result = $auth_stmt->get_result();
            $auth_row = $auth_result->fetch_assoc();

            if (!$auth_row) {
                echo "Error: Authorized person not found.";
                exit();
            }

            $ap_id = $auth_row['ap_id'];
            $up_id = 1; 

            $messages = [];
            $fetchQuery = "SELECT * FROM university_message WHERE message_id IN ($ids)";
            $result = $conn->query($fetchQuery);

            while ($row = $result->fetch_assoc()) {
                $messages[] = $row;
            }
            $deleteReplies = "DELETE FROM message_reply WHERE message_id IN ($ids)";
            $conn->query($deleteReplies);

            $deleteMessages = "DELETE FROM university_message WHERE message_id IN ($ids)";
            if ($conn->query($deleteMessages) === TRUE) {

                if (!empty($messages)) {
                    $archivedAt = date("Y-m-d H:i:s");
                    $originalTable = 'university_message';

                    $archiveQuery = "INSERT INTO university_archive (original_table, record_id, archive_description, archived_at, archived_by, up_id) 
                                    VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($archiveQuery);

                    foreach ($messages as $msg) {
                        $archiveDescription = json_encode($msg, JSON_UNESCAPED_UNICODE); // Encode each message individually
                        $stmt->bind_param("sissii", $originalTable, $msg['message_id'], $archiveDescription, $archivedAt, $ap_id, $up_id);
                        $stmt->execute();
                    }
                }

                $log_date = date("Y-m-d");
                $log_time = date("H:i:s");

                $logQuery = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
                $logStmt = $conn->prepare($logQuery);

                foreach ($messages as $msg) {
                    $log_description = "Deleted subject(s): (" . $msg['message_subject'] . ")";
                    $logStmt->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
                    $logStmt->execute();
                }


                echo "Success";
            } else {
                echo "Error deleting messages: " . $conn->error;
            }
        } else {
            echo "Error: Invalid input format.";
        }
    } else {
        echo "No IDs received.";
    }
} else {
    echo "Invalid request.";
}
// delete message end
?>

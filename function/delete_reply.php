<?php
session_start();
include("../connection/dbconnection.php");

// Set timezone to Cambodia
date_default_timezone_set('Asia/Phnom_Penh');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply_ids'])) {
    $reply_ids = $_POST['reply_ids'];

    // Prepare statement to fetch deleted messages
    $placeholders = implode(",", array_fill(0, count($reply_ids), "?"));
    $query = "SELECT reply_id, reply_message, ap_id FROM message_reply WHERE reply_id IN ($placeholders)";
    $stmt = $conn->prepare($query);
    
    $stmt->bind_param(str_repeat("i", count($reply_ids)), ...$reply_ids);
    $stmt->execute();
    $result = $stmt->get_result();

    $deleted_replies = [];
    while ($row = $result->fetch_assoc()) {
        $deleted_replies[] = $row;
    }
    $stmt->close();

    // Delete replies
    $query = "DELETE FROM message_reply WHERE reply_id IN ($placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat("i", count($reply_ids)), ...$reply_ids);

    if ($stmt->execute()) {
        // Log deletion process
        foreach ($deleted_replies as $reply) {
            $reply_id = $reply['reply_id'];
            $reply_message = $reply['reply_message'];
            $ap_id = $reply['ap_id'];

            // Fetch user_id from authorized_person
            $query = "SELECT user_id FROM authorized_person WHERE ap_id = ?";
            $stmt_user = $conn->prepare($query);
            $stmt_user->bind_param("i", $ap_id);
            $stmt_user->execute();
            $result_user = $stmt_user->get_result();
            $user_row = $result_user->fetch_assoc();
            $user_id = $user_row['user_id'] ?? null;
            $stmt_user->close();

            // Insert into history_log
            if ($user_id) {
                $log_description = "Deleted reply " . $reply_message . "";
                $log_date = date("Y-m-d"); // Cambodia date
                $log_time = date("H:i:s"); // Cambodia time

                $query_log = "INSERT INTO history_log (description, log_date, log_time, user_id) VALUES (?, ?, ?, ?)";
                $stmt_log = $conn->prepare($query_log);
                $stmt_log->bind_param("sssi", $log_description, $log_date, $log_time, $user_id);
                $stmt_log->execute();
                $stmt_log->close();
            }
        }
        echo "Success";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

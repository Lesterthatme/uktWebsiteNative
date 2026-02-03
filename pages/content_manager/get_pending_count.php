<?php
require '../../connection/dbconnection.php';

// Count unread messages
$message_query = "SELECT COUNT(*) AS unread_messages FROM university_message WHERE status = 'unread'";
$message_result = $conn->query($message_query);
$unread_messages = 0;

if ($message_result) {
    $message_row = $message_result->fetch_assoc();
    $unread_messages = $message_row['unread_messages'];
}

// Return JSON response
echo json_encode([
    'unread_messages' => $unread_messages
]);
?>

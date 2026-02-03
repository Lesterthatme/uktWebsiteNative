<?php
require '../../connection/dbconnection.php';

// Count pending accounts
$pending_query = "SELECT COUNT(*) AS pending_count FROM user_account WHERE account_status = 'pending'";
$pending_result = $conn->query($pending_query);
$pending_count = 0;

if ($pending_result) {
    $pending_row = $pending_result->fetch_assoc();
    $pending_count = $pending_row['pending_count'];
}

// Count unread messages
$message_query = "SELECT COUNT(*) AS unread_messages FROM university_message WHERE status = 'unread'";
$message_result = $conn->query($message_query);
$unread_messages = 0;

if ($message_result) {
    $message_row = $message_result->fetch_assoc();
    $unread_messages = $message_row['unread_messages'];
}

// Calculate total notifications
$total_notifications = $pending_count + $unread_messages;

// Return JSON response
echo json_encode([
    'pending_count' => $pending_count,
    'unread_messages' => $unread_messages,
    'total_notifications' => $total_notifications
]);
?>

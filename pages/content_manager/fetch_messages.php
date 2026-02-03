<?php
include("../../connection/dbconnection.php");

$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$whereClause = "";

// Filter messages based on read/unread status
if ($filter === "read") {
    $whereClause = "WHERE status = 'read'";
} elseif ($filter === "unread") {
    $whereClause = "WHERE status = 'unread'";
}

// Query to format the date dynamically
$query = "SELECT message_id, message_subject, status,
    CASE 
        WHEN DATE(date_sent) = CURDATE() 
        THEN CONCAT('Today ', DATE_FORMAT(date_sent, '%h:%i %p')) 
        ELSE DATE_FORMAT(date_sent, '%M %d, %Y') 
    END AS date_sent_formatted
    FROM university_message 
    $whereClause 
    ORDER BY date_sent DESC";

$result = $conn->query($query);

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>

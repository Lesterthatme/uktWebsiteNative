<?php
$sql = "SELECT 
  uc_day, 
  uc_month, 
  uc_title, 
  CONCAT(uc_month, '-', LPAD(uc_day, 2, '0')) AS full_date
FROM university_calendar
ORDER BY 
  uc_month ASC,
  uc_day ASC";

$result = $conn->query($sql);

$today = date('Y-m-d');

$past = [];
$today_or_next = null;
$upcoming = [];

// Separate dates
while ($row = $result->fetch_assoc()) {
    $date = $row['full_date'];

    if ($date < $today) {
        $past[] = $row;
    } elseif ($date == $today && !$today_or_next) {
        $today_or_next = $row;
    } elseif (!$today_or_next) {
        // first future date becomes today_or_next
        $today_or_next = $row;
    } else {
        $upcoming[] = $row;
    }
}

// Pick items according to your rule
$result = [];

// 2 old
$result = array_merge($result, array_slice($past, -2));

// 1 today or soon
if ($today_or_next) {
    $result[] = $today_or_next;
}

// 2 upcoming (if available)
$result = array_merge($result, array_slice($upcoming, 0, 2));

// Fill remaining if less than 5
if (count($result) < 5) {
    $needed = 5 - count($result);
    $result = array_merge($result, array_slice($past, max(0, count($past) - 2 - $needed), $needed));
}

<?php
$sql = "SELECT 
  uc_day, 
  uc_month, 
  uc_title, 
  CONCAT(LPAD(uc_month, 2, '0'), '-', LPAD(uc_day, 2, '0')) AS full_date
FROM university_calendar
ORDER BY 
  uc_month ASC,
  uc_day ASC";

$query = $conn->query($sql);

$today = date('m-d'); // ✅ SAME FORMAT as full_date

$past = [];
$today_or_next = null;
$upcoming = [];

// Separate dates
while ($row = $query->fetch_assoc()) {
    $date = $row['full_date'];

    if ($date < $today) {
        $past[] = $row;
    } elseif ($date == $today && !$today_or_next) {
        $today_or_next = $row;
    } elseif (!$today_or_next) {
        $today_or_next = $row;
    } else {
        $upcoming[] = $row;
    }
}

// Final result
$final = [];



// 2 past
foreach (array_slice($past, -2) as $item) {
    $final[] = $item;
}

// 1 today or next
if ($today_or_next) {
    $final[] = $today_or_next;
}

// 2 upcoming
foreach (array_slice($upcoming, 0, 2) as $item) {
    $final[] = $item;
}

// ✅ Remove duplicates (IMPORTANT FIX)
$unique = [];
$seen = [];

foreach ($final as $item) {
    if (!in_array($item['full_date'], $seen)) {
        $seen[] = $item['full_date'];
        $unique[] = $item;
    }
}

// Replace final with unique values
$final = $unique;

if (count($final) < 5) {
    foreach ($past as $item) {
        if (!in_array($item['full_date'], array_column($final, 'full_date'))) {
            $final[] = $item;
        }
    }

    foreach ($upcoming as $item) {
        if (!in_array($item['full_date'], array_column($final, 'full_date'))) {
            $final[] = $item;
        }
    }
}
// // debug
// echo "<pre>";
// print_r($final);
// echo "</pre>";

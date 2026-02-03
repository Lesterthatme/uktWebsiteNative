<?php
include 'connection/dbconnection.php';

if (isset($_GET['department_id'])) {
    $department_id = intval($_GET['department_id']);

    $query = "SELECT dm_name FROM department WHERE department_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $department_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $dm_name);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        echo json_encode(["dm_name" => $dm_name ? $dm_name : "Unknown Department"]);
    } else {
        echo json_encode(["dm_name" => "Unknown Department"]);
    }
} else {
    echo json_encode(["dm_name" => "Unknown Department"]);
}
?>

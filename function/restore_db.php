<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

$con = mysqli_connect("localhost", "root", "", "kratie_db");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set timezone
date_default_timezone_set("Asia/Manila");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["database_file"])) {
    $file_tmp = $_FILES["database_file"]["tmp_name"];

    // Debug: Check if the file is uploaded
    if (!is_uploaded_file($file_tmp)) {
        die("File upload error. Please select a valid .sql file.");
    }

    $sql = '';
    $error = '';

    // Disable foreign key checks
    if (!mysqli_query($con, 'SET foreign_key_checks = 0')) {
        die("Error disabling foreign key checks: " . mysqli_error($con));
    }

    // Drop all tables before restoring
    $result = mysqli_query($con, "SHOW TABLES");
    if (!$result) {
        die("Error fetching tables: " . mysqli_error($con));
    }

    while ($row = mysqli_fetch_array($result)) {
        if (!mysqli_query($con, "DROP TABLE IF EXISTS " . $row[0])) {
            die("Error dropping table " . $row[0] . ": " . mysqli_error($con));
        }
    }

    // Enable foreign key checks
    if (!mysqli_query($con, 'SET foreign_key_checks = 1')) {
        die("Error enabling foreign key checks: " . mysqli_error($con));
    }

    // Read SQL file
    $lines = file($file_tmp);
    if (!$lines) {
        die("Error reading SQL file.");
    }

    foreach ($lines as $line) {
        if (substr($line, 0, 2) == '--' || trim($line) == '') {
            continue;
        }
        $sql .= $line;
        if (substr(trim($line), -1, 1) == ';') {
            if (!mysqli_query($con, $sql)) {
                $error .= "SQL Error: " . mysqli_error($con) . "\n";
            }
            $sql = '';
        }
    }

    // Show success or error message
    if (!empty($error)) {
        echo "<script>alert('Error restoring database: " . addslashes($error) . "');</script>";
    } else {
        echo json_encode(["status" => "success", "message" => "Database restored successfully!"]);
        exit;
    }
}
?>

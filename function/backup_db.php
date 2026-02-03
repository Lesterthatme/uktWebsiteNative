<?php 
$con = mysqli_connect("localhost", "u123573546_uktadmin", "UKT2.0_db", "u123573546_uktnew_db");

// Set the correct timezone (change to your preferred timezone)
date_default_timezone_set("Asia/Manila"); // Example: Philippine Time (PHT)

if (isset($_POST['backup'])) {
    $tables = [];
    $sql = "SHOW TABLES";
    $result = mysqli_query($con, $sql);
    
    while ($row = mysqli_fetch_row($result)) {
        $tables[] = $row[0];
    }

    $sqlScript = "-- Database Backup\n";
    $sqlScript .= "-- Generated on " . date("Y-m-d H:i:s") . " (Timezone: " . date_default_timezone_get() . ")\n\n";

    foreach ($tables as $table) {
        // Get table creation script
        $query = "SHOW CREATE TABLE `$table`";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_row($result);
        $sqlScript .= "\n\n" . $row[1] . ";\n\n";

        // Get table data
        $query = "SELECT * FROM `$table`";
        $result = mysqli_query($con, $query);
        $columnCount = mysqli_num_fields($result);
        
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO `$table` VALUES(";
            for ($j = 0; $j < $columnCount; $j++) {
                if (isset($row[$j])) {
                    $sqlScript .= '"' . mysqli_real_escape_string($con, $row[$j]) . '"';
                } else {
                    $sqlScript .= 'NULL';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
        $sqlScript .= "\n";
    }

    if (!empty($sqlScript)) {
        $timestamp = date("Y-m-d_H-i-s");
        $backup_file_name = __DIR__ . "/kratie_backup_$timestamp.sql";
        file_put_contents($backup_file_name, $sqlScript);

        header('Content-Description: File Transfer');
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="kratie_backup_' . $timestamp . '.sql"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($backup_file_name));
        readfile($backup_file_name);

        unlink($backup_file_name);
        exit;
    } else {
        die("Failed to create backup.");
    }
}
?>

<?php
$servername = "127.0.0.1";
$username = "root@";
$password = "";
$dbname = "ukt";

date_default_timezone_set('Asia/Phnom_Penh');

$conn = new mysqli($servername, $username, $password, $dbname, 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("SET time_zone = '+07:00'");

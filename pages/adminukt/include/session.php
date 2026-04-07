<?php
include '../../connection/dbconnection.php';
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != "Administrator") {
    header('Location: ' . BASE_URL . 'pages/adminukt/login.php');
    exit;
}

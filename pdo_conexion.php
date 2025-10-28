<?php

// For your local version (conexion.php on your local machine):
// NOTE: This file has been updated for local XAMPP development
// Original remote server configuration:
// $username = "dzambrano1";
// $password = "Wutevogo7754*";

$servername = "localhost";
$username = "root";  // Changed from dzambrano1 to root for local XAMPP
$password = "";       // Changed from Wutevogo7754* to empty for local XAMPP

$dbname = "bufalino";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
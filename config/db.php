<?php
$host = "localhost";
$user = "root";
$pass = "root"; // If you set a MySQL root password, write it here
$db = "nppamroha";

// $host = "localhost";
// $user = "u982107329_root";
// $pass = "Nppshikarpur@1root";
// $db = "u982107329_nppshikarpur";

// Connect to MySQL
$conn = new mysqli($host, $user, $pass);

// If connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create DB if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $db");

// Select DB
$conn->select_db($db);
?>

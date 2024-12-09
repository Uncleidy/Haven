<?php
// Database connection settings
$servername = "sql111.infinityfree.com";
$username = "if0_37876797";
$password = "TempCover123.";
$dbname = "if0_37876797_policy_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

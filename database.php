<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "Junaid_Product";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8mb4");
?>

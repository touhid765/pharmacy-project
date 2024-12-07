<?php
// Database connection configuration
$host = "localhost";      // Hostname
$port = "3309";           // MySQL port
$username = "root";       // Replace with your MySQL username
$password = "";           // Replace with your MySQL password
$database = "pharmacy";   // Replace with your database name

// Create a new connection
$mysqli = new mysqli($host, $username, $password, $database, $port);

// Check for connection errors
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Connection successful (no output shown on the page)
?>




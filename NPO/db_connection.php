<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'npo_db';

$connection = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your XAMPP MySQL root password if set
$dbname = "faculty_timetablemanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

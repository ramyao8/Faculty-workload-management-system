<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in as a faculty member
if ($_SESSION['user'] !== 'faculty' || !isset($_SESSION['faculty_id'])) {
    header("Location: index.php");
    exit();
}

$faculty_id = $_SESSION['faculty_id'];

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    // Update the faculty member's password in the database
    $sql_update = "UPDATE faculty_login SET password = ? WHERE faculty_id = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $password, $faculty_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Password updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating password.";
    }

    $stmt->close();

    // Redirect back to the faculty dashboard
    header("Location: faculty_dashboard.php");
    exit();
}
?>

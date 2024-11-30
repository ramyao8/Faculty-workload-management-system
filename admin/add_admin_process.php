<?php
// Start session
session_start();

// Include database connection
include 'db_connect.php';

// Get form data
$admin_id = $_POST['admin_id'];  // Admin ID entered manually (string/varchar)
$new_username = $_POST['username'];
$new_password = $_POST['password'];

// Validate form data
if (empty($admin_id) || empty($new_username) || empty($new_password)) {
    die("Please fill in all fields.");
}

// Check if the admin_id already exists
$id_check_query = "SELECT * FROM admin WHERE admin_id = ?";
$stmt = $conn->prepare($id_check_query);
$stmt->bind_param("s", $admin_id);  // 's' for string
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Error: Admin ID already exists. Please use a unique Admin ID.");
} else {
    // Insert the new admin with the manually entered admin_id
    $sql = "INSERT INTO admin (admin_id, username, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $admin_id, $new_username, $new_password);  // 'sss' for three strings

    if ($stmt->execute()) {
        echo "New admin added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Close statement and connection
$stmt->close();
$conn->close();
?>

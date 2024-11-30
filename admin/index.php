<?php
session_start();
include 'db_connect.php'; // Make sure this file connects to your database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check admin login using prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Check if the password matches (assuming passwords are stored as plain text in the database)
        if ($password === $row['password']) {
            $_SESSION['user'] = 'admin';
            header("Location: admin/admin_dashboard.php");
            exit();
        }
    }
    $stmt->close();

    // Check faculty login using prepared statements for security
    $stmt = $conn->prepare("SELECT * FROM faculty_login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password===$row['password']) {
            $_SESSION['user'] = 'faculty';
            $_SESSION['faculty_id'] = $row['faculty_id']; // Store faculty_id in session
            header("Location: faculty_dashboard.php");
            exit();
        }
    } else {
        echo "Invalid username or password";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center><img src="https://sves.org.in/ecap/collegeimages/title_head.jpg" width="1500"></center>
    <center><img src="https://sves.org.in/ecap/collegeimages/body.jpg" width="1500"></center><br><br><br><br>
    <p align="center" style="color:blue;">User Login</p>
    <center>
        <form method="post" action="index.php">
            Username: <input type="text" name="username" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
    </center>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Add Admin</title>
    <link rel="stylesheet" href="add_adminstyle.css">
</head>
<body>
    <h1>Add New Admin</h1>
    <form action="add_admin_process.php" method="POST">
        <label for="admin_id">Admin ID:</label>
        <input type="text" id="admin_id" name="admin_id" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Add Admin">
    </form>
    <a href="admin_dashboard.php" class="button-link">Back to Dashboard</a>
</body>
</html>

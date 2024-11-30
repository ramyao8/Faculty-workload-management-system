<?php
include 'db_connect.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_faculty'])) {
        // Retrieve and sanitize input
        $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']);
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); // Note: storing plain text passwords is insecure

        // Check if faculty_id is provided and is not empty
        if (!empty($faculty_id)) {
            // Check if the faculty_id already exists
            $check_sql = "SELECT * FROM faculty WHERE faculty_id = '$faculty_id'";
            $check_result = mysqli_query($conn, $check_sql);
            if (mysqli_num_rows($check_result) > 0) {
                echo "Error: Faculty ID already exists!";
            } else {
                // Insert faculty
                $sql = "INSERT INTO faculty (faculty_id, name, department, qualification) VALUES ('$faculty_id', '$name', '$department', '$qualification')";
                if (mysqli_query($conn, $sql)) {
                    // Insert faculty login details
                    $login_sql = "INSERT INTO faculty_login (faculty_id, username, password) VALUES ('$faculty_id', '$username', '$password')";
                    if (mysqli_query($conn, $login_sql)) {
                        echo "Faculty added and login details set successfully";
                    } else {
                        echo "Error: " . $login_sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        } else {
            echo "Faculty ID is required!";
        }
    }
}

// Fetch all faculty data with a LEFT JOIN to include login details if available
$sql = "SELECT f.faculty_id, f.name, f.department, f.qualification, fl.username 
        FROM faculty f 
        LEFT JOIN faculty_login fl ON f.faculty_id = fl.faculty_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Faculty</title>
    <link rel="stylesheet" type="text/css" href="facultystyles.css"> <!-- Link to the CSS file -->
</head>
<body>
    <h2>Manage Faculty</h2>
    <form method="post">
        <h3>Add Faculty</h3>
        <label for="faculty_id">Faculty ID:</label>
        <input type="text" name="faculty_id" required>
        <label for="name">Name:</label>
        <input type="text" name="name" required>
        <label for="department">Department:</label>
        <select name="department" required>
            <option value="CSE">CSE</option>
            <option value="CST">CST</option>
            <option value="CAI">CAI</option>
            <option value="CAD">CAD</option>
            <option value="AIML">AIML</option>
            <option value="ECE">ECE</option>
            <option value="ECT">ECT</option>
            <option value="EEE">EEE</option>
            <option value="CIVIL">CIVIL</option>
            <option value="MECH">MECH</option>
        </select>
        <label for="qualification">Qualification:</label>
        <select name="qualification" required>
            <option value="Professor">Professor</option>
            <option value="Sr Assistant Professor">Sr Assistant Professor</option>
            <option value="Assistant Professor">Assistant Professor</option>
            <option value="Associate Professor">Associate Professor</option>
            <option value="Lecturer">Lecturer</option>
        </select>
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <input type="submit" name="add_faculty" value="Add Faculty">
    </form>

    <table>
        <thead>
            <tr>
                <th>Faculty ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Qualification</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['faculty_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td><?php echo $row['qualification']; ?></td>
                    <td>
                        <?php
                        // Display username if available
                        echo isset($row['username']) ? $row['username'] : "No username found";
                        ?>
                    </td>
                    <td>
                        <a href="edit_faculty.php?id=<?php echo $row['faculty_id']; ?>">Edit</a>
                        <a href="delete_faculty.php?id=<?php echo $row['faculty_id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br><br> <a href="admin_dashboard.php" class="button-link">Back to Dashboard</a>
</body>
</html>

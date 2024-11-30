<?php
include 'db_connect.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_subject'])) {
        // Add subject logic
        $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $semester = intval($_POST['semester']);

        $sql = "INSERT INTO subject (subject_name, department, semester) VALUES ('$subject_name', '$department', $semester)";
        if (mysqli_query($conn, $sql)) {
            echo "Subject added successfully";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Fetch all department data for dropdown
$departments = ["CSE", "CST", "CAI", "CAD", "AIML", "ECE", "ECT", "EEE", "CIVIL", "MECH"];

// Fetch all subjects for display
$sql = "SELECT * FROM subject";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Subjects</title>
    <link rel="stylesheet" type="text/css" href="subjectstyles.css"> <!-- Link to the CSS file -->
</head>
<body>
    <h2>Manage Subjects</h2>
    
    <!-- Add Subject Form -->
    <form method="post">
        <h3>Add Subject</h3>
        <label for="subject_name">Subject Name:</label>
        <input type="text" name="subject_name" required>

        <label for="department">Department:</label>
        <select name="department" required>
            <?php foreach ($departments as $dept): ?>
                <option value="<?php echo htmlspecialchars($dept); ?>"><?php echo htmlspecialchars($dept); ?></option>
            <?php endforeach; ?>
        </select>

        <label for="semester">Semester:</label>
        <select name="semester" required>
            <option value="">Select Semester</option>
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>

        <input type="submit" name="add_subject" value="Add Subject">
    </form>

    <!-- Subjects Table -->
    <table>
        <thead>
            <tr>
                <th>Subject ID</th>
                <th>Subject Name</th>
                <th>Department</th>
                <th>Semester</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['subject_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['subject_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['department']); ?></td>
                    <td><?php echo htmlspecialchars($row['semester']); ?></td>
                    <td>
                        <a href="edit_subject.php?id=<?php echo htmlspecialchars($row['subject_id']); ?>">Edit</a>
                        <a href="delete_subject.php?id=<?php echo htmlspecialchars($row['subject_id']); ?>">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <br><br> 
<a href="admin_dashboard.php" class="button-link">Back to Dashboard</a>
</body>
</html>

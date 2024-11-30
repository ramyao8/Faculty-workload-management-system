<?php
include 'db_connect.php';

// Check if 'id' parameter is set and is not empty
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Retrieve and sanitize faculty ID from URL parameter
    $faculty_id = (int)$_GET['id'];

    // Fetch faculty details
    $sql = "SELECT * FROM faculty WHERE faculty_id = $faculty_id";
    $result = mysqli_query($conn, $sql);
    $faculty = mysqli_fetch_assoc($result);

    // Check if the faculty exists
    if (!$faculty) {
        echo "No faculty found with the provided ID.";
        exit();
    }
} else {
    // Redirect to manage_faculty.php if 'id' is not set or is empty
    header("Location: manage_faculty.php");
    exit();
}

// Handle form submission for updating faculty
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update faculty logic
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $qualification = mysqli_real_escape_string($conn, $_POST['qualification']);

    // Update the faculty record
    $sql = "UPDATE faculty SET name='$name', department='$department', qualification='$qualification' WHERE faculty_id=$faculty_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: manage_faculty.php"); // Redirect to main page after update
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Faculty</title>
</head>
<body>
    <h2>Edit Faculty</h2>
    <form method="post">
        <label for="faculty_id">Faculty ID:</label>
        <input type="text" name="faculty_id" value="<?php echo htmlspecialchars($faculty['faculty_id']); ?>" readonly>
        <p><em>The Faculty ID cannot be modified.</em></p><br>

        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($faculty['name']); ?>" required><br>

        <label for="department">Department:</label>
        <select name="department" required>
            <option value="CSE" <?php echo ($faculty['department'] == 'CSE') ? 'selected' : ''; ?>>CSE</option>
            <option value="CST" <?php echo ($faculty['department'] == 'CST') ? 'selected' : ''; ?>>CST</option>
            <option value="CAI" <?php echo ($faculty['department'] == 'CAI') ? 'selected' : ''; ?>>CAI</option>
            <option value="CAD" <?php echo ($faculty['department'] == 'CAD') ? 'selected' : ''; ?>>CAD</option>
            <option value="AIML" <?php echo ($faculty['department'] == 'AIML') ? 'selected' : ''; ?>>AIML</option>
            <option value="ECE" <?php echo ($faculty['department'] == 'ECE') ? 'selected' : ''; ?>>ECE</option>
            <option value="ECT" <?php echo ($faculty['department'] == 'ECT') ? 'selected' : ''; ?>>ECT</option>
            <option value="EEE" <?php echo ($faculty['department'] == 'EEE') ? 'selected' : ''; ?>>EEE</option>
            <option value="CIVIL" <?php echo ($faculty['department'] == 'CIVIL') ? 'selected' : ''; ?>>CIVIL</option>
            <option value="MECH" <?php echo ($faculty['department'] == 'MECH') ? 'selected' : ''; ?>>MECH</option>
        </select><br>

        <label for="qualification">Qualification:</label>
        <select name="qualification" required>
            <option value="Professor" <?php echo ($faculty['qualification'] == 'Professor') ? 'selected' : ''; ?>>Professor</option>
            <option value="Sr Assistant Professor" <?php echo ($faculty['qualification'] == 'Sr Assistant Professor') ? 'selected' : ''; ?>>Sr Assistant Professor</option>
            <option value="Assistant Professor" <?php echo ($faculty['qualification'] == 'Assistant Professor') ? 'selected' : ''; ?>>Assistant Professor</option>
            <option value="Associate Professor" <?php echo ($faculty['qualification'] == 'Associate Professor') ? 'selected' : ''; ?>>Associate Professor</option>
            <option value="Lecturer" <?php echo ($faculty['qualification'] == 'Lecturer') ? 'selected' : ''; ?>>Lecturer</option>
        </select><br>

        <input type="submit" value="Update Faculty">
    </form>
</body>
</html>

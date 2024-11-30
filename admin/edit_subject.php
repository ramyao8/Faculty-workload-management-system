<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $subject_id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM subject WHERE subject_id = $subject_id");
    $subject = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $subject_name = mysqli_real_escape_string($conn, $_POST['subject_name']);
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $semester = intval($_POST['semester']);

        $sql = "UPDATE subject SET subject_name='$subject_name', department='$department', semester=$semester WHERE subject_id=$subject_id";
        if (mysqli_query($conn, $sql)) {
            echo "Subject updated successfully";
            header('Location: manage_subjects.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "No subject ID specified.";
}

// Fetch all department data for dropdown
$departments = ["CSE", "CST", "CAI", "CAD", "AIML", "ECE", "ECT", "EEE", "CIVIL", "MECH"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subject</title>
</head>
<body>
    <h2>Edit Subject</h2>
    <form method="post">
        <label for="subject_name">Subject Name:</label>
        <input type="text" name="subject_name" value="<?php echo htmlspecialchars($subject['subject_name']); ?>" required><br>

        <label for="department">Department:</label>
        <select name="department" required>
            <?php foreach ($departments as $dept): ?>
                <option value="<?php echo htmlspecialchars($dept); ?>" <?php if ($dept == $subject['department']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($dept); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="semester">Semester:</label>
        <select name="semester" required>
            <option value="">Select Semester</option>
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?php echo $i; ?>" <?php if ($i == $subject['semester']) echo 'selected'; ?>>
                    <?php echo $i; ?>
                </option>
            <?php endfor; ?>
        </select><br>

        <input type="submit" value="Update Subject">
    </form>
</body>
</html>

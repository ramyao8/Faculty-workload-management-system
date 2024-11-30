<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $timetable_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete the timetable entry from the database
    $stmt = $conn->prepare("DELETE FROM timetable WHERE timetable_id = ?");
    $stmt->bind_param("i", $timetable_id);

    if ($stmt->execute()) {
        // Redirect to manage timetable page after successful deletion
        
        header("Location: manage_timetable.php");
        exit;
    } else {
        echo "<p style='color:red;'>Error deleting timetable: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p style='color:red;'>Invalid timetable ID!</p>";
}

$conn->close();
?>

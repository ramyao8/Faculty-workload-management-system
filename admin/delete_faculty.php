<?php
include 'db_connect.php';

// Retrieve faculty ID from URL parameter and sanitize it
$faculty_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Check if faculty_id is provided and is not empty
if (!empty($faculty_id)) {
    // First, delete records from timetable table
    $delete_timetable_sql = "DELETE FROM timetable WHERE faculty_id = '$faculty_id'";
    if (mysqli_query($conn, $delete_timetable_sql)) {
        // Then, delete records from faculty_login table
        $delete_login_sql = "DELETE FROM faculty_login WHERE faculty_id = '$faculty_id'";
        if (mysqli_query($conn, $delete_login_sql)) {
            // Now, delete the faculty record
            $delete_faculty_sql = "DELETE FROM faculty WHERE faculty_id = '$faculty_id'";
            if (mysqli_query($conn, $delete_faculty_sql)) {
                header("Location: manage_faculty.php"); // Redirect to main page after deletion
                exit();
            } else {
                echo "Error: " . $delete_faculty_sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "Error: " . $delete_login_sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $delete_timetable_sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Faculty ID is missing or invalid.";
}
?>

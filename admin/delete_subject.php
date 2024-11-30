<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $subject_id = intval($_GET['id']);
    $sql = "DELETE FROM subject WHERE subject_id = $subject_id";
    if (mysqli_query($conn, $sql)) {
        echo "Subject deleted successfully";
        header('Location: manage_subjects.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "No subject ID specified.";
}
?>

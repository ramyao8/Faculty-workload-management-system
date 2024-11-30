<?php
// faculty_dashboard.php

session_start();
include 'db_connect.php';

// Check if the user is logged in as a faculty member
if ($_SESSION['user'] !== 'faculty' || !isset($_SESSION['faculty_id'])) {
    header("Location: index.php");
    exit();
}

$faculty_id = $_SESSION['faculty_id'];

// Fetch faculty details
$sql_faculty = "SELECT name,faculty_id, department, qualification FROM faculty WHERE faculty_id = ?";
$stmt = $conn->prepare($sql_faculty);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result_faculty = $stmt->get_result();
$row_faculty = $result_faculty->fetch_assoc();
$stmt->close();

// Fetch timetable data with additional details
$timetable_data = [];
$sql_timetable = "SELECT t.timetable_id, t.day, t.start_time, t.end_time, t.branch, t.semester, t.section, 
                         s.subject_name, t.faculty_id, t.other_work 
                  FROM timetable t 
                  LEFT JOIN subject s ON t.subject_id = s.subject_id 
                  WHERE t.faculty_id = ?";
$stmt = $conn->prepare($sql_timetable);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$result_timetable = $stmt->get_result();

while ($row_timetable = $result_timetable->fetch_assoc()) {
    $day = $row_timetable['day'];
    $start_time = $row_timetable['start_time'];

    // Check if the subject exists
    if ($row_timetable['subject_name']) {
        // If a subject is present, do not display other work
        $timetable_data[$day][$start_time] = [
            'timetable_id' => $row_timetable['timetable_id'],
            'subject_name' => $row_timetable['subject_name'],
            'end_time' => $row_timetable['end_time'],
            'branch' => $row_timetable['branch'] ?? 'N/A',
            'semester' => $row_timetable['semester'] ?? 'N/A',
            'section' => $row_timetable['section'] ?? 'N/A',
            'other_work' => '' // Clear other work if subject exists
        ];
    } else {
        // If no subject is present, show the other work
        $timetable_data[$day][$start_time] = [
            'timetable_id' => null, // No timetable ID since no subject is assigned
            'subject_name' => '', // No subject name
            'end_time' => '', // No end time
            'branch' => '', // No branch
            'semester' => '', // No semester
            'section' => '', // No section
            'other_work' => $row_timetable['other_work'] ?? 'N/A' // Show other work
        ];
    }
}
$stmt->close();

// Define periods and days
$periods = [
    "09:30:00 - 10:30:00",
    "10:30:00 - 11:20:00",
    "11:20:00 - 12:10:00",
    "12:10:00 - 13:00:00",
    "14:00:00 - 14:50:00",
    "14:50:00 - 15:40:00",
    "15:40:00 - 16:30:00"
];
$days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

// Include the HTML file to render the dashboard
include 'faculty_dashboard.html.php';
?>

<?php
include 'db_connect.php';

// Handle faculty selection and filtering
$selected_faculty_id = isset($_POST['faculty_id']) ? mysqli_real_escape_string($conn, $_POST['faculty_id']) : null;

// Handle adding or updating timetable
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_timetable'])) {
        // Add timetable code here...
        $faculty_id = isset($_POST['faculty_id']) ? mysqli_real_escape_string($conn, $_POST['faculty_id']) : null;
        $subject_name = isset($_POST['subject_name']) ? mysqli_real_escape_string($conn, $_POST['subject_name']) : null;
        $branch = isset($_POST['branch']) ? mysqli_real_escape_string($conn, $_POST['branch']) : null;
        $semester = isset($_POST['semester']) ? mysqli_real_escape_string($conn, $_POST['semester']) : null;
        $section = isset($_POST['section']) ? mysqli_real_escape_string($conn, $_POST['section']) : null;
        $day = isset($_POST['day']) ? mysqli_real_escape_string($conn, $_POST['day']) : null;
        $start_time = isset($_POST['start_time']) ? mysqli_real_escape_string($conn, $_POST['start_time']) : null;
        $end_time = isset($_POST['end_time']) ? mysqli_real_escape_string($conn, $_POST['end_time']) : null;
        
        if ($faculty_id && $subject_name && $branch && $semester && $section && $day && $start_time && $end_time ) {
            // Check if faculty already has a schedule at the same time
            $faculty_schedule_query = "SELECT 1 FROM timetable WHERE faculty_id = ? AND day = ? AND start_time = ?";
            $stmt = $conn->prepare($faculty_schedule_query);
            $stmt->bind_param("iss", $faculty_id, $day, $start_time);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "<p style='color:red;'>Faculty already has a schedule at this time!</p>";
                $stmt->close();
                exit();
            }
            $stmt->close();

            // Check if the same branch and section already have a schedule at the same time
            $branch_section_schedule_query = "SELECT 1 FROM timetable WHERE branch = ? AND semester = ? AND section = ? AND day = ? AND start_time = ?";
            $stmt = $conn->prepare($branch_section_schedule_query);
            $stmt->bind_param("sssss", $branch, $semester, $section, $day, $start_time);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "<p style='color:red;'>This branch and section already have a schedule at this time!</p>";
                $stmt->close();
                exit();
            }
            $stmt->close();

            // Get subject_id from subject_name
            $subject_query = "SELECT subject_id FROM subject WHERE subject_name = ?";
            $stmt = $conn->prepare($subject_query);
            $stmt->bind_param("s", $subject_name);
            $stmt->execute();
            $stmt->bind_result($subject_id);
            $stmt->fetch();
            $stmt->close();

            if ($subject_id) {
                // Insert new timetable entry
                $stmt = $conn->prepare("INSERT INTO timetable (faculty_id, subject_id, branch, semester, section, day, start_time, end_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iissssss", $faculty_id, $subject_id, $branch, $semester, $section, $day, $start_time, $end_time);

                if ($stmt->execute()) {
                    echo "<p style='color:green;'>Timetable added successfully!</p>";
                } else {
                    echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                echo "<p style='color:red;'>Invalid Subject Name!</p>";
            }
        } else {
            echo "<p style='color:red;'>All fields are required!</p>";
        }
    } // Handle adding faculty timetable
    if(isset($_POST['add_faculty_timetable'])) {
        $faculty_id = isset($_POST['faculty_id']) ? mysqli_real_escape_string($conn, $_POST['faculty_id']) : null;
        $day = isset($_POST['day']) ? mysqli_real_escape_string($conn, $_POST['day']) : null;
        $start_time = isset($_POST['start_time']) ? mysqli_real_escape_string($conn, $_POST['start_time']) : null;
        $end_time = isset($_POST['end_time']) ? mysqli_real_escape_string($conn, $_POST['end_time']) : null;
        $other_work = isset($_POST['other_work']) ? mysqli_real_escape_string($conn, $_POST['other_work']) : null;
    
        if ($faculty_id && $day && $start_time && $end_time && $other_work) {
            // Check if faculty already has a schedule at the same time
            $faculty_schedule_query = "SELECT 1 FROM timetable WHERE faculty_id = ? AND day = ? AND start_time = ?";
            $stmt = $conn->prepare($faculty_schedule_query);
            $stmt->bind_param("iss", $faculty_id, $day, $start_time);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "<p style='color:red;'>Faculty already has a schedule at this time!</p>";
                $stmt->close();
                exit();
            }
            $stmt->close();
    
            // Insert new faculty timetable entry
            $stmt = $conn->prepare("INSERT INTO timetable (faculty_id, day, start_time, end_time, other_work) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $faculty_id, $day, $start_time, $end_time, $other_work);
    
            if ($stmt->execute()) {
                echo "<p style='color:green;'>Faculty Timetable added successfully!</p>";
            } else {
                echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color:red;'>All fields are required!</p>";
        }
    }
    elseif (isset($_POST['update_timetable'])) {
        // Handle updating timetable
        $timetable_id = isset($_POST['timetable_id']) ? mysqli_real_escape_string($conn, $_POST['timetable_id']) : null;
        $faculty_id = isset($_POST['faculty_id']) ? mysqli_real_escape_string($conn, $_POST['faculty_id']) : null;
        $subject_name = isset($_POST['subject_name']) ? mysqli_real_escape_string($conn, $_POST['subject_name']) : null;
        $branch = isset($_POST['branch']) ? mysqli_real_escape_string($conn, $_POST['branch']) : null;
        $semester = isset($_POST['semester']) ? mysqli_real_escape_string($conn, $_POST['semester']) : null;
        $section = isset($_POST['section']) ? mysqli_real_escape_string($conn, $_POST['section']) : null;
        $day = isset($_POST['day']) ? mysqli_real_escape_string($conn, $_POST['day']) : null;
        $start_time = isset($_POST['start_time']) ? mysqli_real_escape_string($conn, $_POST['start_time']) : null;
        $end_time = isset($_POST['end_time']) ? mysqli_real_escape_string($conn, $_POST['end_time']) : null;
        
        if ($faculty_id && $subject_name && $branch && $semester && $section && $day && $start_time && $end_time ) {
            // Check if faculty already has a schedule at the same time
            $faculty_schedule_query = "SELECT 1 FROM timetable WHERE faculty_id = ? AND day = ? AND start_time = ? AND timetable_id != ?";
            $stmt = $conn->prepare($faculty_schedule_query);
            $stmt->bind_param("issi", $faculty_id, $day, $start_time, $timetable_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "<p style='color:red;'>Faculty already has a schedule at this time!</p>";
                $stmt->close();
                exit();
            }
            $stmt->close();

            // Check if the same branch and section already have a schedule at the same time
            $branch_section_schedule_query = "SELECT 1 FROM timetable WHERE branch = ? AND semester = ? AND section = ? AND day = ? AND start_time = ? AND timetable_id != ?";
            $stmt = $conn->prepare($branch_section_schedule_query);
            $stmt->bind_param("sssssi", $branch, $semester, $section, $day, $start_time, $timetable_id);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                echo "<p style='color:red;'>This branch and section already have a schedule at this time!</p>";
                $stmt->close();
                exit();
            }
            $stmt->close();

            // Get subject_id from subject _name
            $subject_query = "SELECT subject_id FROM subject WHERE subject_name = ?";
            $stmt = $conn->prepare($subject_query);
            $stmt->bind_param("s", $subject_name);
            $stmt->execute();
            $stmt->bind_result($subject_id);
            $stmt->fetch();
            $stmt->close();

            if ($subject_id) {
                // Update timetable entry
                $stmt = $conn->prepare("UPDATE timetable SET faculty_id=?, subject_id=?, branch=?, semester=?, section=?, day=?, start_time=?, end_time=? WHERE timetable_id=?");
                $stmt->bind_param("iissssssi", $faculty_id, $subject_id, $branch, $semester, $section, $day, $start_time, $end_time, $timetable_id);

                if ($stmt->execute()) {
                    echo "<p style='color:green;'>Timetable updated successfully!</p>";
                } else {
                    echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
                }
                $stmt->close();
            } else {
                echo "<p style='color:red;'>Invalid Subject Name!</p>";
            }
        } else {
            echo "<p style='color:red;'>All fields are required!</p>";
        }
    }
}

/// Fetch faculty names for filtering
$faculty_query = "SELECT faculty_id, name FROM faculty ";
$faculty_result = mysqli_query($conn, $faculty_query);
$faculty_data = [];
while ($row = mysqli_fetch_assoc($faculty_result)) {
    $faculty_data[] = $row;
}

// Fetch subjects for the dropdown list
$subject_query = "SELECT subject_id, subject_name FROM subject";
$subject_result = mysqli_query($conn, $subject_query);
$subject_data = [];
while ($row = mysqli_fetch_assoc($subject_result)) {
    $subject_data[] = $row;
}
// Fetch timetable records based on selected faculty
$timetable_data = [];
if ($selected_faculty_id) {
    $timetable_sql = "SELECT t.timetable_id, t.day, t.start_time, t.end_time, t.branch, t.semester, t.section, s.subject_name, t.faculty_id, t.other_work 
                  FROM timetable t 
                  LEFT JOIN subject s ON t.subject_id = s.subject_id 
                  WHERE t.faculty_id = ?";

    $timetable_stmt = $conn->prepare($timetable_sql);
    $timetable_stmt->bind_param("i", $selected_faculty_id);
    $timetable_stmt->execute();
    $timetable_result = $timetable_stmt->get_result();

    while ($row = $timetable_result->fetch_assoc()) {
        if ($row['subject_name']) {
            $timetable_data[$row['day']][$row['start_time']] = [
                'timetable_id' => $row['timetable_id'],
                'subject_name' => $row['subject_name'],
                'branch' => $row['branch'],
                'semester' => $row['semester'],
                'section' => $row['section'],
                'faculty_id' => $row['faculty_id'],
                'end_time' => $row['end_time'],
                'other_work' => ''
            ];
        } else {
            $timetable_data[$row['day']][$row['start_time']] = [
                'timetable_id' => $row['timetable_id'],
                'subject_name' => '',
                'branch' => '',
                'semester' => '',
                'section' => '',
                'faculty_id' => $row['faculty_id'],
                'end_time' => $row['end_time'],
                'other_work' => $row['other_work']
            ];
        }
    }

    $timetable_stmt->close();
}

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Timetable</title>
    <link rel="stylesheet" type="text/css" href="times.css">
    <style>
        .edit-form {
            display: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <script>
        function showEditForm(id) {
            document.getElementById('edit-form-' + id).style.display = 'block';
            document.getElementById('edit-button-' + id).style.display = 'none';
        }
    </script>
</head>
<body>
<div class="header-container">
    <h2>Manage WorkLoad</h2>
    </div>
<div class="flex-container">
    <!-- Faculty Selection Form -->
    <form method="post">
      <div class="header">  
        <h3 align="center">Select Faculty to view their schedule</h3>
    </div><br><br>
        <label>Faculty:</label>
        <select name="faculty_id" required>
            <option value="">Select Faculty</option>
            <?php foreach ($faculty_data as $row): ?>
                <option value="<?php echo $row['faculty_id']; ?>" <?php echo ($selected_faculty_id == $row['faculty_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="filter_faculty" value="Select">
    </form>

    <!-- Add Timetable Form -->
   
    <form method="post" action="">
    <div class="header"> 
    <h3 align="center">Add workload</h3>
            </div><br><br>
    <label for="faculty_id">Select Faculty:</label>
        <select id="faculty_id" name="faculty_id" required>
            <option value="">--Select Faculty--</option>
            <?php foreach ($faculty_data as $row): ?>
                <option value="<?php echo htmlspecialchars($row['faculty_id']); ?>">
                    <?php echo htmlspecialchars($row['faculty_id']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <label>Subject:</label>
        <select name="subject_name" required>
            <option value="">Select Subject</option>
            <?php foreach ($subject_data as $row): ?>
                <option value="<?php echo htmlspecialchars($row['subject_name']); ?>">
                    <?php echo htmlspecialchars($row['subject_name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Branch:</label>
        <input type="text" name="branch" required><br>
        <label for="semester">Semester:</label>
        <select name="semester" required>
            <option value="">Select Semester</option>
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
            <?php endfor; ?>
        </select><br>

        <label>Section:</label>
    <select name="section" required>
        <option value="">Select Section</option>
        <?php for ($i = 'A'; $i <= 'D'; $i++): ?>
            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
        <?php endfor; ?>
    </select><br>
        <label>Day:</label>
        <select name="day" required>
            <option value="">Select Day</option>
            <?php foreach ($days as $day): ?>
                <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Start Time:</label>
        <select name="start_time" required>
            <option value="">Select Start Time</option>
            <?php foreach ($periods as $period): ?>
                <?php $time = explode(" - ", $period)[0]; ?>
                <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>End Time:</label>
        <select name="end_time" required>
            <option value="">Select End Time</option>
            <?php foreach ($periods as $period): ?>
                <?php $time = explode(" - ", $period)[1]; ?>
                <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
            <?php endforeach; ?>
        </select><br>
       
        <input type="submit" name="add_timetable" value="submit">
    </form>

    <!--add faculty timetable form-->

    <form method="post" action="">
    <div class="header"> 
    <h3 align="center" >Manage workload</h3>
            </div><br><br>
    <label for="faculty_id">Select Faculty:</label>
    <select id="faculty_id" name="faculty_id" required>
        <option value="">--Select Faculty--</option>
        <?php foreach ($faculty_data as $row): ?>
            <option value="<?php echo htmlspecialchars($row['faculty_id']); ?>">
                <?php echo htmlspecialchars($row['faculty_id']); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <label>Day:</label>
    <select name="day" required>
        <option value="">Select Day</option>
        <?php foreach ($days as $day): ?>
            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Start Time:</label>
    <select name="start_time" required>
        <option value="">Select Start Time</option>
        <?php foreach ($periods as $period): ?>
            <?php $time = explode(" - ", $period)[0]; ?>
            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>End Time:</label>
    <select name="end_time" required>
        <option value="">Select End Time</option>
        <?php foreach ($periods as $period): ?>
            <?php $time = explode(" - ", $period)[1]; ?>
            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Other Work:</label>
    <input type="text" name="other_work" required><br>
    <input type="submit" name="add_faculty_timetable" value="Submit">
    </form>
</div>  
<!-- Timetable Display Table -->
<br><br>
<h3 align="center" style="background-color:lightgreen";>Workload</h3>
       
<table>
    <thead>
        <tr>
            <th>Day</th>
            <?php foreach ($periods as $period): ?>
                <th><?php echo htmlspecialchars($period); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($days as $day): ?>
            <tr>
                <td><?php echo $day; ?></td>
                <?php foreach ($periods as $period): ?>
                    <?php
                    $start_time = explode(" - ", $period)[0];
                    $entry = isset($timetable_data[$day][$start_time]) ? $timetable_data[$day][$start_time] : null;
                    ?>
                    <td>
                        <?php if ($entry): ?>
                            <?php if ($entry['subject_name']): ?>
                                <?php echo htmlspecialchars($entry['subject_name']); ?><br>
                                Branch: <?php echo htmlspecialchars($entry['branch']); ?><br>
                                Semester: <?php echo htmlspecialchars($entry['semester']); ?><br>
                                Section: <?php echo htmlspecialchars($entry['section']); ?><br>
                                <button id="edit-button-<?php echo $entry['timetable_id']; ?>" onclick="showEditForm(<?php echo $entry['timetable_id']; ?>)">Edit</button>
                                <a href="delete_timetable.php?id=<?php echo $entry['timetable_id']; ?>" onclick="return confirm('Are you sure you want to delete this timetable?');">Delete</a>
                                <div class="edit-form" id="edit-form-<?php echo $entry['timetable_id']; ?>">
                                    <form method="post">
                                        <input type="hidden" name="timetable_id" value="<?php echo $entry['timetable_id']; ?>">
                                        <label>Faculty ID:</label>
                                        <input type="text" name="faculty_id" value="<?php echo $entry['faculty_id']; ?>" readonly><br>
                                        <label>Subject:</label>
                                        <select name="subject_name" required>
                                            <option value="">Select Subject</option>
                                            <?php
                                            mysqli_data_seek($subject_result, 0); // Reset subject result pointer
                                            while ($subject_row = mysqli_fetch_assoc($subject_result)): ?>
                                                <option value="<?php echo htmlspecialchars($subject_row['subject_name']); ?>" <?php echo ($entry['subject_name'] == $subject_row['subject_name']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($subject_row['subject_name']); ?>
                                                </option >
                                            <?php endwhile; ?>
                                        </select><br>
                                        <label>Branch:</label>
                                        <input type="text" name="branch" value="<?php echo $entry['branch']; ?>" required><br>
                                        <label for="semester">Semester:</label>
                                        <select name="semester" readonly>
                                            <option value="">Select Semester</option>
                                            <?php for ($i = 1; $i <= 8; $i++): ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select><br>

                                        <label>Section:</label>
                                        <select name="section" required>
                                         <option value="">Select Section</option>
                                          <?php for ($i = 'A'; $i <= 'D'; $i++): ?>
                                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                          <?php endfor; ?>
                                        </select><br>
                                        <label>Day:</label>
                                        <select name="day" required>
                                            <option value="">Select Day</option>
                                            <?php foreach ($days as $day_option): ?>
                                                <option value="<?php echo $day_option; ?>" <?php echo ($day_option == $day) ? 'selected' : ''; ?>>
                                                    <?php echo $day_option; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select><br>
                                        <label>Start Time:</label>
                                        <select name="start_time" required>
                                            <option value="">Select Start Time</option>
                                            <?php foreach ($periods as $period_option): ?>
                                                <?php $time_option = explode(" - ", $period_option)[0]; ?>
                                                <option value="<?php echo $time_option; ?>" <?php echo ($time_option == $start_time) ? 'selected' : ''; ?>>
                                                    <?php echo $time_option; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select><br>
                                        <label>End Time:</label>
                                        <select name="end_time" required>
                                            <option value="">Select End Time</option>
                                            <?php foreach ($periods as $period_option): ?>
                                                <?php $time_option_end = explode(" - ", $period_option)[1]; ?>
                                                <option value="<?php echo $time_option_end; ?>" <?php echo ($time_option_end == $entry['end_time']) ? 'selected' : ''; ?>>
                                                    <?php echo $time_option_end; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select><br>
                                        <input type="submit" name="update_timetable" value="Update Timetable">
                                    </form>
                                </div>
                            <?php else: ?>
                                <?php echo htmlspecialchars($entry['other_work']); ?><br>
                                <a href="delete_timetable.php?id=<?php echo $entry['timetable_id']; ?>" onclick="return confirm('Are you sure you want to delete this timetable?');">Delete</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
    <br><br> <a href="admin_dashboard.php" class="button-link">Back to Dashboard</a><br><br>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
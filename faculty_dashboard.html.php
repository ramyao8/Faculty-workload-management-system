<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        header img {
            width: 100%;
            height: auto;
        }

        .container {
            display: flex;
            flex: 1;
        }

        .sidebar {
            width: 250px;
            background-color: powderblue;
            padding: 20px;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #5dade2;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3498db;
        }

        .content-section {
            display: none;
            margin-top: 20px;
        }

        .content-section table, .content-section th, .content-section td {
            border: 1px solid black;
        }

        .content-section th, .content-section td {
            padding: 12px;
            text-align: center;
        }

        .content-section th {
            background-color: #f2f2f2;
        }

        @media screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                padding: 10px;
            }

            .main-content {
                padding: 10px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
    <script>
        function toggleSection(sectionId) {
            var sections = document.querySelectorAll('.content-section');
            sections.forEach(function(section) {
                if (section.id === sectionId) {
                    section.style.display = (section.style.display === "none" || section.style.display === "") ? "block" : "none";
                } else {
                    section.style.display = "none";
                }
            });
        }

        function togglePasswordVisibility() {
            var passwordField = document.getElementById('password');
            var visibilityCheckbox = document.getElementById('show-password');
            if (visibilityCheckbox.checked) {
                passwordField.type = 'text';
            } else {
                passwordField.type = 'password';
            }
        }
    </script>
</head>
<body>
    <header>
        <img src="https://sves.org.in/ecap/collegeimages/title_head.jpg" alt="Title Header">
    </header>

    <div class="container">
        <div class="sidebar">
            <h2>Faculty Dashboard</h2>
            <table>
                <tr>
                    <td><button type="button" onclick="toggleSection('faculty-details')">Faculty Details</button></td>
                </tr>
                <tr>
                    <td><button type="button" onclick="toggleSection('update-form')">Update Password</button></td>
                </tr>
                <tr>
                    <td><button type="button" onclick="toggleSection('timetable')">WorkLoad</button></td>
                </tr>
                <tr>
                    <td><button type="button" onclick="window.location.href='logout.php'">Logout</button></td>
                </tr>
            </table>
        </div>

        <div class="main-content">
            <!-- Faculty Details Section -->
            <div id="faculty-details" class="content-section">
                <h2>Faculty Details</h2>
                <p>Name: <?php echo htmlspecialchars($row_faculty['name']); ?></p>
                <p>ID: <?php echo htmlspecialchars($row_faculty['faculty_id'])?></p>
                <p>Department: <?php echo htmlspecialchars($row_faculty['department']); ?></p>
                <p>Qualification: <?php echo htmlspecialchars($row_faculty['qualification']); ?></p>
            </div>

            <!-- Update Password Section -->
            <div id="update-form" class="content-section">
                <h2>Update Password</h2>
                <form method="post" action="update_faculty.php">
                    <label for="password">New Password:</label>
                    <input type="password" id="password" name="password" required><br><br>
                    <input type="checkbox" id="show-password" onclick="togglePasswordVisibility()">
                    <label for="show-password">Show Password</label><br><br>

                    <input type="submit" value="Update">
                </form>
            </div>

            <!-- Timetable Section -->
            <div id="timetable" class="content-section">
                <h2>WorkLoad</h2>
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
                                <td><?php echo htmlspecialchars($day); ?></td>
                                <?php foreach ($periods as $period): ?>
                                    <?php
                                    $start_time = explode(" - ", $period)[0];
                                    $event = $timetable_data[$day][$start_time] ?? null;
                                    ?>
                                    <td>
                                        <?php if ($event && $event['subject_name']): ?>
                                            <?php echo htmlspecialchars($event['subject_name']); ?><br>
                                            branch-<?php echo htmlspecialchars($event['branch']); ?><br> Sem- <?php echo htmlspecialchars($event['semester']); ?><br>Sec- <?php echo htmlspecialchars($event['section']); ?>
                                        <?php elseif ($event && $event['other_work']): ?>
                                            <?php echo htmlspecialchars($event['other_work']); ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="adminstyle.css">
    <!-- Include any additional styles or scripts here -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- FontAwesome for icons -->
</head>
<body>
    <div class="header-image">
        <img src="https://sves.org.in/ecap/collegeimages/title_head.jpg" width="1500" alt="Header Image">
    </div>
    
    <div class="topbar">
        <div class="dashboard-title">Admin Dashboard</div>
        <button onclick="logout()" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</button>
    </div>
    
    <nav class="sidebar">
        <ul>
            <li><a href="manage_faculty.php" onclick="showSection('manageFaculty')"><i class="fas fa-chalkboard-teacher"></i> Manage Faculty</a></li>
            <li><a href="manage_subjects.php" onclick="showSection('manageSubjects')"><i class="fas fa-book"></i> Manage Subjects</a></li>
            <li><a href="manage_timetable.php" onclick="showSection('manageTimetable')"><i class="fas fa-calendar-alt"></i> Manage Workload</a></li>
            <li><a href="add_admin.php" onclick="showSection('addAdmin')"><i class="fas fa-user-plus"></i> Add Admin</a></li>
        </ul>
    </nav>
    
    <div class="content">
        <!-- Sections will be displayed here based on the user's selection -->
        <div id="manageFaculty" class="section" style="display: none;">
            <!-- Manage Faculty content goes here -->
        </div>
        <div id="manageSubjects" class="section" style="display: none;">
            <!-- Manage Subjects content goes here -->
        </div>
        <div id="manageTimetable" class="section" style="display: none;">
            <!-- Manage Timetable content goes here -->
        </div>
        <div id="addAdmin" class="section" style="display: none;">
            <!-- Add Admin content goes here -->
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.style.display = 'none';
            });
            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
        }

        function logout() {
            // Implement logout functionality
            window.location.href = "logoutadmin.php";
        }
    </script>
</body>
</html>

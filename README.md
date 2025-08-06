# Faculty Timetable Management System

A web-based system built with PHP and MySQL that allows administrators to manage faculty members, subjects, and class timetables. Faculty members can log in to view their assigned schedules.

## 💡 Why This Project?
Managing faculty schedules manually in educational institutions is time-consuming, error-prone, and inefficient. This project aims to digitize and simplify the process of creating, managing, and viewing academic timetables for faculty members.

✅ Problems It Solves
❌ Paper-based timetables are hard to update and distribute.

❌ Admins must manually cross-check for conflicts (faculty/room/time).

❌ Faculty members don’t have a centralized view of their schedules.

This system addresses those issues with:

A centralized web interface for managing all timetable data.

Real-time access for faculty to see their assigned schedule.

Admin control over subjects, staff, and time slots.


## 🚀 Features

### 👨‍💼 Admin Functionalities
- Admin login dashboard
- Add and manage admin users
- Manage faculty data
- Manage subjects
- Assign and update timetables

### 👨‍🏫 Faculty Functionalities
- Faculty login dashboard
- View personalized timetable

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS
- **Backend**: PHP
- **Database**: MySQL
- **Database Tool**: phpMyAdmin (used for SQL dump)

## 🗂️ Project Structure

| File/Folder         | Description |
|---------------------|-------------|
| `admin_dashboard.php` | Admin dashboard overview |
| `add_admin.php`        | Admin registration panel |
| `manage_faculty.php`   | Add/edit/delete faculty records |
| `manage_subjects.php`  | Add/edit/delete subject details |
| `manage_timetable.php` | Create and modify timetable entries |
| `faculty_dashboard.php`| Faculty panel to view their schedule |
| `update_faculty.php`   | Update faculty member info |
| `faculty.sql`          | MySQL dump file with complete database structure and sample data |

## 🧱 Database Schema

Imported via `faculty.sql`. It contains the following tables:

- `admin`: Admin login credentials
- `faculty`: Faculty details
- `faculty_login`: Faculty login credentials
- `subject`: Subject details
- `timetable`: Time slot assignments
- `password_reset`: Reset token management

## 🧑‍💻 How to Use

1. **Clone the Repository**
   ```bash
   git clone https://github.com/your-username/your-repo.git
Set Up the Server

Place the project in your web root (htdocs for XAMPP or www for WAMP).

Example:

makefile
Copy
Edit
C:\xampp\htdocs\timetable-management\
Import the Database

Open phpMyAdmin.

Create a new database (e.g., faculty_timetablemanagement).

Import the faculty.sql file.

Configure Database Connection

If not already present, create a config.php file to handle DB connection.

Sample:

php
Copy
Edit
<?php
$conn = mysqli_connect("localhost", "root", "", "faculty_timetablemanagement");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
Run the Project

Navigate to:

arduino
Copy
Edit
http://localhost/timetable-management/admin_dashboard.php
**📸 Screenshots**
**Admin Dashboard**
<img width="1919" height="996" alt="image" src="https://github.com/user-attachments/assets/8ebb69e8-7acf-44f7-a9e0-6fb35bf3cc3d" />
<img width="1919" height="1019" alt="image" src="https://github.com/user-attachments/assets/4665c5df-52a4-454e-b728-70783fabb228" />
<img width="1919" height="951" alt="image" src="https://github.com/user-attachments/assets/08138d51-e7a7-4118-9181-76018b849818" />
<img width="1919" height="1014" alt="image" src="https://github.com/user-attachments/assets/8f946df2-d624-4355-be24-c867dfc7e020" />
<img width="1919" height="913" alt="image" src="https://github.com/user-attachments/assets/0ce726c0-b5dc-43b3-b46b-0ccdb5bc85d9" />
<img width="1919" height="652" alt="image" src="https://github.com/user-attachments/assets/12f55103-7816-4fe1-92fe-66219c324724" />
<img width="1919" height="1013" alt="image" src="https://github.com/user-attachments/assets/714aff27-6a6b-49f0-abbf-1b8480c196fc" />

**Faculty Dashboard**
<img width="1919" height="1019" alt="image" src="https://github.com/user-attachments/assets/908a2084-6b7e-490a-980a-ad9b4995f07a" />
<img width="1919" height="1018" alt="image" src="https://github.com/user-attachments/assets/9e227e92-554b-4bb7-8602-76785b727bce" />


🔐 Default Login Credentials
Role	Username	Password
Admin	admin	admin
Faculty	john	john

(More can be found in faculty.sql)

📃 License
This project is open source and available under the MIT License.

🙋‍♂️ Author
**Ramya sada**

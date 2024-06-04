<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve date from GET request
$date = $_GET['date'];

// Get all students
$students_query = "SELECT student_id, first_name, last_name FROM students";
$students_result = $conn->query($students_query);

if ($students_result->num_rows > 0) {
    echo '<table>';
    echo '<thead><tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Present</th></tr></thead><tbody>';
    while ($student = $students_result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $student['student_id'] . '</td>';
        echo '<td>' . $student['first_name'] . '</td>';
        echo '<td>' . $student['last_name'] . '</td>';
        echo '<td><input type="checkbox" class="attendance-checkbox" data-student-id="' . $student['student_id'] . '"></td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
    echo '<button onclick="submitAttendance(\'' . $date . '\')">Submit Attendance</button>';
} else {
    echo 'No students found.';
}

$conn->close();
?>

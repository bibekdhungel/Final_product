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

// Retrieve selected date from the request
$date = $_GET['date'];

// Query to fetch attendance data along with student information
$sql = "SELECT students.student_id, students.first_name, students.last_name, attendance_table.is_present
        FROM students
        LEFT JOIN attendance_table ON students.student_id = attendance_table.student_id
        WHERE attendance_table.attendance_date = '$date'";

$result = $conn->query($sql);

// Check for SQL errors
if ($result === false) {
    die("SQL Error: " . $conn->error);
}

if ($result->num_rows > 0) {
    // Output table header
    echo "<tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Attendance</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["student_id"] . "</td>";
        echo "<td>" . $row["first_name"] . "</td>";
        echo "<td>" . $row["last_name"] . "</td>";
        echo "<td>";
        echo "<input type='checkbox' class='attendance-checkbox' data-sid='" . $row["student_id"] . "'";
        echo $row["is_present"] ? " checked" : ""; // Check the checkbox if attendance is present
        echo ">";
        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "No attendance record found for the selected date.";
}

$conn->close();
?>

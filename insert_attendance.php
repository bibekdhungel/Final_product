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

// Retrieve data from POST request
$data = json_decode(file_get_contents('php://input'), true);
$date = $data['date'];
$attendance = $data['attendance'];

foreach ($attendance as $record) {
    $student_id = $record['student_id'];
    $is_present = $record['is_present'];
    
    // Check if attendance already exists for this student on the given date
    $attendance_check_query = "SELECT * FROM attendance_table WHERE student_id = ? AND attendance_date = ?";
    $stmt = $conn->prepare($attendance_check_query);
    $stmt->bind_param("is", $student_id, $date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // If no attendance record exists, insert a new record
        $insert_query = "INSERT INTO attendance_table (student_id, attendance_date, is_present) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("isi", $student_id, $date, $is_present);
        if (!$stmt->execute()) {
            echo "Error inserting attendance for student ID $student_id: " . $stmt->error;
        }
    } else {
        // Update existing record
        $update_query = "UPDATE attendance_table SET is_present = ? WHERE student_id = ? AND attendance_date = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("iis", $is_present, $student_id, $date);
        if (!$stmt->execute()) {
            echo "Error updating attendance for student ID $student_id: " . $stmt->error;
        }
    }
}

echo "Attendance records updated for the selected date.";

$conn->close();
?>

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
$sid = $_POST['sid'];
$isPresent = $_POST['is_present'];
$date = $_POST['date']; // Retrieve the selected date

// Check if the required fields are not empty
if (empty($sid) || !isset($isPresent) || empty($date)) {
    die("Error: Missing required data.");
}

// Prepare SQL statement to check if the attendance record already exists
$existing_record_query = "SELECT * FROM attendance_table WHERE student_id = ? AND attendance_date = ?";
$stmt = $conn->prepare($existing_record_query);
if (!$stmt) {
    die("SQL Error (prepare): " . $conn->error);
}
$stmt->bind_param("is", $sid, $date);
$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("SQL Error (execute): " . $stmt->error);
}

if ($result->num_rows > 0) {
    // If a record already exists, update it
    $update_query = "UPDATE attendance_table SET is_present = ? WHERE student_id = ? AND attendance_date = ?";
    $stmt = $conn->prepare($update_query);
    if (!$stmt) {
        die("SQL Error (prepare update): " . $conn->error);
    }
    $stmt->bind_param("iis", $isPresent, $sid, $date);
    if ($stmt->execute()) {
        echo "Attendance updated successfully";
    } else {
        echo "Error updating attendance: " . $stmt->error;
    }
} else {
    // If no record exists, insert a new record
    $insert_query = "INSERT INTO attendance_table (student_id, is_present, attendance_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    if (!$stmt) {
        die("SQL Error (prepare insert): " . $conn->error);
    }
    $stmt->bind_param("iis", $sid, $isPresent, $date);
    if ($stmt->execute()) {
        echo "Attendance recorded successfully"; // Notify success
    } else {
        echo "Error adding attendance: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>

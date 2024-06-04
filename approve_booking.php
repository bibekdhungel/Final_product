<?php
// Include database connection file
include_once 'connection.php';

// Retrieve the JSON data sent from the client-side JavaScript
$data = json_decode(file_get_contents('php://input'), true);

// Function to insert booking data into the database
function insertStudent($conn, $student) {
    // Prepare and bind parameters
    $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, date_of_birth, gender, user_id, emergency_contact_name, address, home_phone, mobile_phone, emergency_contact_number, booking_days, booking_notes, booking_duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisssssssi", $student['first_name'], $student['last_name'], $student['date_of_birth'], $student['gender'], $student['user_id'], $student['emergency_contact_name'], $student['address'], $student['home_phone'], $student['mobile_phone'], $student['emergency_contact_number'], $student['booking_days'], $student['booking_notes'], $student['booking_duration']);

    // Execute prepared statement
    $result = $stmt->execute();

    // Close statement
    $stmt->close();

    return $result;
}

// Call the insertStudent function with the data received from the client-side JavaScript
$result = insertStudent($conn, $data);

// Return JSON response indicating success or failure
if ($result) {
    // Student successfully inserted
    $response = array('success' => true, 'message' => 'Student enrolled successfully.');
} else {
    // Error occurred while inserting student
    $response = array('success' => false, 'message' => 'Error: Failed to enroll student.');
}

// Send JSON response back to the client-side JavaScript
header('Content-Type: application/json');
echo json_encode($response);

// Close database connection
$conn->close();
?>

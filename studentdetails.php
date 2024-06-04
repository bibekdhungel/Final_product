<?php
// Include database connection file
include_once 'connection.php';

// Initialize an empty array to store student details
$studentDetails = [];

// Query to fetch student details
$query = "SELECT * FROM students";

// Perform the query
$result = $conn->query($query);

// Check if query executed successfully
if ($result) {
    // Fetch associative array of student details
    while ($row = $result->fetch_assoc()) {
        // Append each student detail to the array
        $studentDetails[] = $row;
    }
    // Free result set
    $result->free();
} else {
    // If query failed, display error message
    echo "Error: " . $conn->error;
}

// Close database connection
$conn->close();

// Convert student details array to JSON format
$jsonData = json_encode($studentDetails);

// Set response header to indicate JSON content type
header('Content-Type: application/json');

// Output JSON data
echo $jsonData;
?>

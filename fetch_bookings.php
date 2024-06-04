<?php
// Include the database connection file
include 'connection.php';

// Query to fetch all bookings
$sql = "SELECT * FROM bookings";

// Execute the query
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Initialize an empty array to store the bookings data
    $bookings = array();

    // Fetch each row of data and store it in the array
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }

    // Send the array as JSON response
    echo json_encode($bookings);
} else {
    // If no rows returned, send an empty array as JSON response
    echo json_encode(array());
}

// Close the database connection
$conn->close();
?>

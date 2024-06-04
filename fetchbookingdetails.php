<?php
// fetchbookingdetails.php

// Include the database connection file
include_once 'connection.php';

// Check if booking ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Query to fetch booking details based on ID
    $sql = "SELECT * FROM bookings WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $bookingDetails = $result->fetch_assoc();
        // Return booking details as JSON
        echo json_encode($bookingDetails);
    } else {
        echo json_encode(array()); // Return empty array if no booking found
    }
} else {
    echo json_encode(array('error' => 'Booking ID not provided'));
}

$conn->close();
?>

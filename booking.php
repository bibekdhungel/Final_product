<?php
// Include the database connection file
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $child_name = $_POST['child_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $username = $_POST['username'];
    $emergency_contact_name = $_POST['emergency_contact_name'];
    $address = $_POST['address'];
    $home_phone = $_POST['home_phone'];
    $mobile_phone = $_POST['mobile_phone'];
    $emergency_contact_number = $_POST['emergency_contact_number'];
    $booking_days = implode(',', $_POST['booking_days']);
    $booking_notes = $_POST['booking_notes'];
    $booking_duration = $_POST['booking-duration'];

    // Prepare and bind SQL statement to insert the booking into the database
    $stmt = $conn->prepare("INSERT INTO bookings (child_name, dob, gender, username, emergency_contact_name, address, home_phone, mobile_phone, emergency_contact_number, booking_days, booking_notes, booking_duration) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssi", $child_name, $dob, $gender, $username, $emergency_contact_name, $address, $home_phone, $mobile_phone, $emergency_contact_number, $booking_days, $booking_notes, $booking_duration);

    // Execute the prepared statement
    if ($stmt->execute() === TRUE) {
        // Redirect the user to the notification page
        header("Location: notification.html");
        exit();
    } else {
        // Log the error instead of echoing it
        error_log("Error: " . $stmt->error);
        echo "An error occurred. Please try again later.";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

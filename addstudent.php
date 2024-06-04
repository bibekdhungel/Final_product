<?php
// Include database connection file
include_once 'connection.php';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST["first-name"];
    $lastName = $_POST["last-name"];
    $dateOfBirth = $_POST["dob"];
    $gender = $_POST["gender"];
    $userId = $_POST["id"]; // Change to userId
    $emergencyContactName = $_POST["Name"];
    $address = $_POST["address"];
    $homePhone = $_POST["home-number"];
    $mobilePhone = $_POST["mobile-number"];
    $emergencyContactNumber = $_POST["Emergency-number"];
    $bookingDays = implode(",", $_POST["book-days"]); // Convert array to comma-separated string
    $bookingNotes = $_POST["booking_notes"];
    $bookingDuration = $_POST["booking-duration"];

    // Check if user_id exists in the users table
    $checkIdQuery = "SELECT id FROM users WHERE id = ?";
    $stmt = $conn->prepare($checkIdQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User ID exists in users table, insert data into students table
        $insertQuery = "INSERT INTO students (first_name, last_name, date_of_birth, gender, user_id, emergency_contact_name, address, home_phone, mobile_phone, emergency_contact_number, booking_days, booking_notes, booking_duration) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssssisssssssi", $firstName, $lastName, $dateOfBirth, $gender, $userId, $emergencyContactName, $address, $homePhone, $mobilePhone, $emergencyContactNumber, $bookingDays, $bookingNotes, $bookingDuration);
        
        if ($stmt->execute()) {
            echo "New student record created successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        // User ID does not exist
        echo "Error: User ID '$userId' does not exist";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>

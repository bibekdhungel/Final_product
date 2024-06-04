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
    $parentUsername = $_POST["parents-username"];
    $emergencyContactName = $_POST["Name"];
    $address = $_POST["address"];
    $homePhone = $_POST["home-number"];
    $mobilePhone = $_POST["mobile-number"];
    $emergencyContactNumber = $_POST["Emergency-number"];
    $bookingDays = implode(",", $_POST["book-days"]); // Convert array to comma-separated string
    $bookingNotes = $_POST["booking_notes"];
    $bookingDuration = $_POST["booking-duration"];

    // Check if parent_username exists in the users table
    $checkParentQuery = "SELECT id FROM users WHERE username = '$parentUsername'";
    $result = $conn->query($checkParentQuery);

    if ($result->num_rows > 0) {
        // Parent exists, retrieve the user_id
        $row = $result->fetch_assoc();
        $userId = $row["id"];

        // Insert data into students table
        $insertQuery = "INSERT INTO students (first_name, last_name, date_of_birth, gender, parent_username, emergency_contact_name, address, home_phone, mobile_phone, emergency_contact_number, booking_days, booking_notes, booking_duration, user_id) 
                        VALUES ('$firstName', '$lastName', '$dateOfBirth', '$gender', '$parentUsername', '$emergencyContactName', '$address', '$homePhone', '$mobilePhone', '$emergencyContactNumber', '$bookingDays', '$bookingNotes', $bookingDuration, $userId)";

        if ($conn->query($insertQuery) === TRUE) {
            echo "New student record created successfully";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } else {
        // Parent does not exist
        echo "Error: Parent with username '$parentUsername' does not exist";
    }
}

// Close connection
$conn->close();
?>

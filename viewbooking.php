<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
        <h3>Booking Details</h3>
        <?php
        // Include the database connection file
        include 'connection.php';

        // Fetch the booking details from the database
        $query = "SELECT * FROM bookings WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $_GET['booking_id']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Output the booking details
            echo "<p><strong>Child Name:</strong> " . $row['child_name'] . "</p>";
            echo "<p><strong>Date of Birth:</strong> " . $row['dob'] . "</p>";
            echo "<p><strong>Gender:</strong> " . $row['gender'] . "</p>";
            echo "<p><strong>Parent's Username:</strong> " . $row['username'] . "</p>";
            echo "<p><strong>Emergency Contact Name:</strong> " . $row['emergency_contact_name'] . "</p>";
            echo "<p><strong>Address:</strong> " . $row['address'] . "</p>";
            echo "<p><strong>Mobile Phone:</strong> " . $row['mobile_phone'] . "</p>";
            echo "<p><strong>Emergency Contact Number:</strong> " . $row['emergency_contact_number'] . "</p>";
            echo "<p><strong>Booking Days:</strong> " . $row['booking_days'] . "</p>";
            echo "<p><strong>Booking Notes:</strong> " . $row['booking_notes'] . "</p>";
            echo "<p><strong>Booking Duration:</strong> " . $row['booking_duration'] . "</p>";
        } else {
            echo "Booking not found";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>

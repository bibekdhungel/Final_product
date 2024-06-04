<?php
// Include the database connection file
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if notification ID is set
    if(isset($_GET['notification_id'])) {
        $notification_id = $_GET['notification_id'];

        // Fetch the latest booking details from the database
        $query = "SELECT * FROM bookings ORDER BY id DESC LIMIT 1";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Output the booking details
            $row = $result->fetch_assoc();
            echo json_encode($row);
        } else {
            echo json_encode(array("error" => "No booking found"));
        }
    } else {
        echo json_encode(array("error" => "Notification ID is not set"));
    }
} else {
    echo json_encode(array("error" => "Invalid request method"));
}
?>

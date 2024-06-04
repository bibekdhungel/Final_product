<?php
include('connection.php');

$date = $_POST['date'];
$description = $_POST['description'];

$sql = "INSERT INTO events (event_date, description) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $date, $description);

if ($stmt->execute()) {
    echo "Event created successfully!";
} else {
    echo "Failed to create event.";
}

$stmt->close();
$conn->close();
?>

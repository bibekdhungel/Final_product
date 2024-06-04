<?php
include('connection.php');

$date = $_GET['date'];

$sql = "SELECT description FROM events WHERE event_date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($events);
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch data from medical_certificates table
$sql = "SELECT student_id, student_name, sick_date, certificate_file_path FROM medical_certificates";

// Execute the query
$result = $conn->query($sql);

// Check if there are any rows returned
$data = array();
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Add absolute path to the certificate file
        $row['certificate_file_path'] = 'uploads/' . $row['certificate_file_path'];
        $data[] = $row;
    }
}

// Set the Content-Type header to application/json
header('Content-Type: application/json');

// Return the data as JSON
echo json_encode($data);

// Close the connection
$conn->close();
?>

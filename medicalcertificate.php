<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (isset($_POST["student_id"]) && isset($_POST["student_name"]) && isset($_POST["date"]) && isset($_FILES["pdf"])) {
        // Database connection parameters
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'project';

        // Create connection
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get form data
        $student_id = $_POST["student_id"];
        $student_name = $_POST["student_name"];
        $sick_date = $_POST["date"];

        // File handling
        $pdf_name = $_FILES["pdf"]["name"];
        $pdf_tmp = $_FILES["pdf"]["tmp_name"];

        // Target directory for uploaded files
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($pdf_name);

        // Check if the file has been uploaded successfully
        if (move_uploaded_file($pdf_tmp, $target_file)) {
            // Set the file path to be stored in the database
            $image = $target_file;

            // Prepare and bind SQL statement
            $stmt = $conn->prepare("INSERT INTO medcert (student_id, student_name, sick_date, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $student_id, $student_name, $sick_date, $image);

            // Execute statement
            if ($stmt->execute()) {
                echo "Medical certificate uploaded successfully.";
                // Redirect back to medical form after 3 seconds
                header("refresh:3;url=medicalcertificate.html");
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close statement and connection
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        $conn->close();
    } else {
        // Required fields are missing
        echo "Please fill all required fields.";
    }
} else {
    echo "Invalid request method.";
    // Redirect back to medical form after 3 seconds
    header("refresh:3;url=medicalcertificate.html");
    exit;
}
?>

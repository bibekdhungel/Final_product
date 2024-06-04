<?php
// Include the database connection file
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set
    if(isset($_POST['first_name'], $_POST['last_name'], $_POST['username'], $_POST['password'], $_POST['user_type'], $_POST['student_id'])) {
        // Assign values from $_POST to variables
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $user_type = $_POST['user_type'];
        $student_id = $_POST['student_id'];

        // Check if the username already exists
        $check_stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();
        if ($result->num_rows > 0) {
            // Username already exists, display error message
            echo "Error: The username is already taken.";
            exit(); // Stop execution
        }
        $check_stmt->close();

        // Check if the student ID exists
        $check_student_stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
        $check_student_stmt->bind_param("i", $student_id);
        $check_student_stmt->execute();
        $student_result = $check_student_stmt->get_result();
        if ($student_result->num_rows === 0) {
            // Student ID does not exist, display error message
            echo "Error: The student ID does not exist or is invalid. It is mandatory for registration.";
            exit(); // Stop execution
        }
        $check_student_stmt->close();

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, password, user_type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $username, $password, $user_type);

        // Execute the prepared statement
        if ($stmt->execute() === TRUE) {
            $user_id = $stmt->insert_id; // Get the ID of the inserted user
            // Based on user type, insert into corresponding table
            switch ($user_type) {
                case 'parent':
                    $parent_stmt = $conn->prepare("INSERT INTO parents (user_id) VALUES (?)");
                    $parent_stmt->bind_param("i", $user_id);
                    $parent_stmt->execute();
                    $parent_stmt->close();
                    break;
                case 'educator':
                    $educator_stmt = $conn->prepare("INSERT INTO educators (user_id) VALUES (?)");
                    $educator_stmt->bind_param("i", $user_id);
                    $educator_stmt->execute();
                    $educator_stmt->close();
                    break;
                default:
                    // Handle other user types if needed
                    break;
            }
            echo "New record created successfully";
        } else {
            // Log the error instead of echoing it
            error_log("Error: " . $stmt->error);
            echo "An error occurred. Please try again later.";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Handle missing or null values
        echo "Error: Required fields are not set.";
    }
}
?>
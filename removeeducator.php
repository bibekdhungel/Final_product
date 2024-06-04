<?php
// Include the database connection file
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the educator ID is provided
    if(isset($_POST['educator_id'])) {
        $educator_id = $_POST['educator_id'];

        // Prepare and bind SQL statement to delete the educator from the educators table
        $delete_educator_stmt = $conn->prepare("DELETE FROM educators WHERE user_id = ?");
        $delete_educator_stmt->bind_param("i", $educator_id);

        // Prepare and bind SQL statement to delete the user from the users table
        $delete_user_stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $delete_user_stmt->bind_param("i", $educator_id);

        // Execute the delete statements
        if ($delete_educator_stmt->execute() === TRUE && $delete_user_stmt->execute() === TRUE) {
            // Deletion successful, redirect to admin page
            echo '<script>
                    alert("Educator removed successfully!");
                    window.location.href = "admin.html"; // Redirect to admin dashboard
                  </script>';
        } else {
            // Error occurred while deleting, redirect back to remove educator page
            echo '<script>
                    alert("Error: Unable to remove educator!");
                    window.location.href = "removeeducator.html"; // Redirect back to remove educator page
                  </script>';
        }

        // Close the statements
        $delete_educator_stmt->close();
        $delete_user_stmt->close();
    } else {
        // Educator ID not provided, display error message
        echo "Error: Educator ID not provided.";
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect if accessed directly without POST method
    header("Location: removeeducator.html");
    exit();
}
?>

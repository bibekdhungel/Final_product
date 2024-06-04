<?php
include('connection.php');

if (isset($_POST['student-id'])) {
    $student_id = $_POST['student-id'];

    // Using prepared statement to prevent SQL injection
    $sql = "DELETE FROM students WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Check if the prepared statement was successfully created
    if (!$stmt) {
        die("Error: Unable to prepare statement. " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $student_id);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo '<script>
                alert("Student removed successfully!");
                window.location.href = "admin.html"; // Redirect to admin dashboard
              </script>';
    } else {
        echo '<script>
                alert("Error: Unable to remove student!");
                window.location.href = "removestudent.html"; // Redirect back to remove student page
              </script>';
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

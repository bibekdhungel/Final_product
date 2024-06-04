<?php

include_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $image = $_FILES['image']['name'];
    $date = $_POST['date'];
    $activity_type = $_POST['activity_type']; // Retrieve activity type
    $description = $_POST['description']; // Retrieve description

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Debugging: Check if file is uploaded successfully
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "The file ". basename($_FILES["image"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }

    $sql = "INSERT INTO activities (image, date, activity_type, description) VALUES ('$image', '$date' , '$activity_type', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "Activity uploaded successfully.";
        // Redirect back to activities form after 3 seconds
        header("refresh:3;url=activities.html");
    } else {
        echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
}
?>

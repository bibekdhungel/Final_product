<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Include the database connection file
include_once "connection.php";

// Check if like, dislike, or comment form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["like"]) || isset($_POST["dislike"])) {
        // Like or Dislike action
        $activityId = $_POST["activity_id"];
        $interactionType = isset($_POST["like"]) ? "like" : "dislike";
        
        // Insert into activity_interactions table
        $sql = "INSERT INTO activity_interactions (activity_id, interaction_type) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $activityId, $interactionType);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST["comment"])) {
        // Comment action
        $activityId = $_POST["activity_id"];
        $comment = $_POST["comment"];
        
        // Insert into activity_interactions table
        $sql = "INSERT INTO activity_interactions (activity_id, comment) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $activityId, $comment);
        $stmt->execute();
        $stmt->close();
    }
}

// Query activities from the database ordered by primary key (assuming 'id' is the primary key column)
$sql = "SELECT * FROM activities ORDER BY id";
$result = mysqli_query($conn, $sql);

// Check if there are any activities
if ($result && mysqli_num_rows($result) > 0) {
    // Start outputting HTML
    echo "<div class='activities-container'>";
    
    // Loop through each activity and display it
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='activity'>";
        // Check if the image file exists before displaying
        $imagePath = "uploads/{$row['image']}";
        if (file_exists($imagePath)) {
            echo "<div class='activity-info'>";
            echo "<h1>{$row['activity_type']}</h1>"; // Display activity type as H1
            echo "<p class='date'>{$row['date']}</p>"; // Display date
            echo "<h2>{$row['description']}</h2>"; // Display description as H2
            echo "</div>";
            echo "<div class='image-container'>";
            echo "<img src='{$imagePath}' alt='Activity Image'>"; // Remove max-width and max-height to allow image to fill container
            echo "</div>";
            
            // Add like, dislike, and comment buttons
            echo "<div class='interaction-buttons'>";
            // Like button with form
            echo "<form method='post'>";
            echo "<input type='hidden' name='activity_id' value='{$row['id']}'>";
            echo "<button class='like-btn' type='submit' name='like'>Like</button>";
            echo "</form>";
            // Dislike button with form
            echo "<form method='post'>";
            echo "<input type='hidden' name='activity_id' value='{$row['id']}'>";
            echo "<button class='dislike-btn' type='submit' name='dislike'>Dislike</button>";
            echo "</form>";
            // Comment textarea with form
            echo "<form method='post'>";
            echo "<input type='hidden' name='activity_id' value='{$row['id']}'>";
            echo "<textarea class='comment-textarea' name='comment' placeholder='Add a comment...'></textarea>";
            echo "<button class='comment-btn' type='submit'>Comment</button>";
            echo "</form>";
            echo "</div>";
        } else {
            echo "<p>Image not found</p>";
        }
        echo "</div>";
    }
    // End of activities-container
    echo "</div>";
} else {
    echo "<p>No activities found.</p>";
}
?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-btn');
    const dislikeButtons = document.querySelectorAll('.dislike-btn');
    const commentForms = document.querySelectorAll('.comment-form');

    likeButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default form submission behavior
            
            if (button.classList.contains('liked')) {
                // If already liked, remove the like
                button.classList.remove('liked');
                button.style.backgroundColor = "white"; // Change background color back to white
            } else {
                // Remove 'liked' class from all like buttons
                likeButtons.forEach(function (btn) {
                    btn.classList.remove('liked');
                    btn.style.backgroundColor = "white"; // Change background color back to white for all like buttons
                });
                // Remove 'disliked' class from all dislike buttons
                dislikeButtons.forEach(function (btn) {
                    btn.classList.remove('disliked');
                    btn.style.backgroundColor = "white"; // Change background color back to white for all dislike buttons
                });
                // Add 'liked' class to clicked button
                button.classList.add('liked');
                button.style.backgroundColor = "#4CAF50"; // Green color for liked button
            }
        });
    });

    dislikeButtons.forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default form submission behavior
            
            if (button.classList.contains('disliked')) {
                // If already disliked, remove the dislike
                button.classList.remove('disliked');
                button.style.backgroundColor = "white"; // Change background color back to white
            } else {
                // Remove 'disliked' class from all dislike buttons
                dislikeButtons.forEach(function (btn) {
                    btn.classList.remove('disliked');
                    btn.style.backgroundColor = "white"; // Change background color back to white for all dislike buttons
                });
                // Remove 'liked' class from all like buttons
                likeButtons.forEach(function (btn) {
                    btn.classList.remove('liked');
                    btn.style.backgroundColor = "white"; // Change background color back to white for all like buttons
                });
                // Add 'disliked' class to clicked button
                button.classList.add('disliked');
                button.style.backgroundColor = "#FF5733"; // Red color for disliked button
            }
        });
    });

    // AJAX comment submission
    commentForms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission behavior
            
            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Comment submitted successfully, you can update the UI if needed
                        console.log('Comment submitted successfully');
                    } else {
                        // Handle error
                        console.error('Error submitting comment');
                    }
                }
            };
            xhr.send(formData);
        });
    });
});

</script>

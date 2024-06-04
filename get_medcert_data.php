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
        $studentId = $_POST["student_id"];
        $interactionType = isset($_POST["like"]) ? "like" : "dislike";
        
        // Insert into interactions table (create this table to store likes/dislikes)
        $sql = "INSERT INTO interactions (student_id, interaction_type) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $studentId, $interactionType);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST["comment"])) {
        // Comment action
        $studentId = $_POST["student_id"];
        $comment = $_POST["comment"];
        
        // Insert into interactions table
        $sql = "INSERT INTO interactions (student_id, comment) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $studentId, $comment);
        $stmt->execute();
        $stmt->close();
    }
}

// Query medcert data from the database
$sql = "SELECT * FROM medcert ORDER BY student_id";
$result = mysqli_query($conn, $sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="medcert-item">';
        echo '<div class="medcert-header">';
        echo '<h2>Student ID: ' . htmlspecialchars($row["student_id"]) . '</h2>';
        echo '<p>Student Name: ' . htmlspecialchars($row["student_name"]) . '</p>';
        echo '<p>Sick Date: ' . htmlspecialchars($row["sick_date"]) . '</p>';
        echo '</div>';
        echo '<img src="' . htmlspecialchars($row["certificate_file_path"]) . '" alt="Certificate Image">';
        echo '<form method="post" action="" class="like-dislike-form">';
        echo '<input type="hidden" name="student_id" value="' . htmlspecialchars($row["student_id"]) . '">';
        echo '<button type="submit" name="like" class="like-btn">Like</button>';
        echo '<button type="submit" name="dislike" class="dislike-btn">Dislike</button>';
        echo '</form>';
        echo '<form method="post" action="" class="comment-form">';
        echo '<input type="hidden" name="student_id" value="' . htmlspecialchars($row["student_id"]) . '">';
        echo '<textarea name="comment" placeholder="Add a comment"></textarea>';
        echo '<button type="submit" name="comment">Comment</button>';
        echo '</form>';
        echo '</div>';
    }
} else {
    echo "No results";
}

$conn->close();
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

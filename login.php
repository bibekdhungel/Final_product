<?php
include('connection.php');

if (isset($_POST['submit'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // Check for empty fields
    if(empty($username) || empty($password)) {
        echo '<script>
                    alert("Please enter both username and password!!");
                    window.location.href = "login.html"; // Redirect to login page
              </script>';
        exit(); // Exit script
    }

    // Using prepared statements to prevent SQL injection
       // Using prepared statements to prevent SQL injection
       $sql_admin = "SELECT * FROM admin WHERE username = ?";
       $stmt_admin = mysqli_prepare($conn, $sql_admin);
       mysqli_stmt_bind_param($stmt_admin, "s", $username);
       mysqli_stmt_execute($stmt_admin);
       $result_admin = mysqli_stmt_get_result($stmt_admin);
   
       if ($result_admin && $row_admin = mysqli_fetch_assoc($result_admin)) {
           $db_password = $row_admin['password']; // Get the password from the database
           if ($password === $db_password) {
               header("Location: admin.html"); // Redirect to admin dashboard
               exit(); // Make sure to exit after redirection
        } else {
            echo '<script>
                        alert("Admin login failed. Invalid username or password!!");
                        window.location.href = "login.html"; // Redirect to login page
                  </script>';
        }
    } else {
        // Check for user login
        $sql_user = "SELECT * FROM users WHERE username = ?";
        $stmt_user = mysqli_prepare($conn, $sql_user);
        mysqli_stmt_bind_param($stmt_user, "s", $username);
        mysqli_stmt_execute($stmt_user);
        $result_user = mysqli_stmt_get_result($stmt_user);

        if ($result_user && $row_user = mysqli_fetch_assoc($result_user)) {
            $hashed_password = $row_user['password'];
            if (password_verify($password, $hashed_password)) {
                $email_parts = explode('@', $username);
                $domain = end($email_parts);
                // Redirect based on domain
                if ($domain == 'parent.com') {
                    header("Location: parentdashboard.html");
                } elseif ($domain == 'educator.com') {
                    header("Location: educatordashboard.html");
                } else {
                    // Redirect to a default page or show an error message
                    header("Location: default.html");
                }
                exit(); // Make sure to exit after redirection
            } else {
                echo '<script>
                            alert("User login failed. Invalid username or password!!");
                            window.location.href = "login.html"; // Redirect to login page
                      </script>';
            }
        } else {
            echo '<script>
                        alert("Login failed. Invalid username or password!!");
                        window.location.href = "login.html"; // Redirect to login page
                  </script>';
        }
    }
}
?>

<?php
session_start(); // Start or resume the session

// If the user is logged in, destroy the session
if (isset($_SESSION['user_id'])) {
    session_destroy();
}


header("Location: login.html");
exit;
?>

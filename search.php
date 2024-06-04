<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve category and search query from the form
    $category = $_GET["category"];
    $query = $_GET["query"];

    // Validate category and redirect to the corresponding details page
    switch ($category) {
        case 'students':
            // Redirect to students details page with the search query as a parameter
            header("Location: studentdetails.html?query=$query");
            exit();
        case 'parents':
            // Redirect to parents details page with the search query as a parameter
            header("Location: parentdetails.html?query=$query");
            exit();
        case 'educators':
            // Redirect to educators details page with the search query as a parameter
            header("Location: educatordetails.html?query=$query");
            exit();
        case 'all':
            // Redirect to all users details page with the search query as a parameter
            header("Location: userdetails.html?query=$query");
            exit();
        default:
            // Invalid category, redirect back to the search page
            header("Location: search.html");
            exit();
    }
}
?>

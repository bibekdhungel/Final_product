<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="parentdashboard.css">
    <link rel="stylesheet" href="display_activities.php">

    <style>
        <style>
        body {
            background-color: #4d0b5c; /* Set background color */
            color: white; /* Set text color to white for better visibility */
        }
        .header {
            position: relative; /* Ensure header can have positioned elements */
            display: flex;
            justify-content: center; /* Center content horizontally */
            align-items: center;
            padding: 10px 20px;
        }
        .header-content {
            display: flex;
            align-items: center;
            text-align: center; /* Center text within the container */
            flex-direction: column; /* Stack logo and text vertically */
        }
        .group-logo {
            margin-bottom: 10px;
        }
        .back-container {
            position: absolute;
            top: 10px;
            right: 20px;
        }
        .back-btn {
            padding: 10px 20px;
            background-color: white;
            color: #4d0b5c;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .header-content h1, .header-content h2 {
            margin: 0; /* Ensure no extra margin */
            color: white; /* Ensure the text color is white */
        }
        .header-content h1 {
            font-size: 2em; /* Set the font size for the main heading */
        }
        .header-content h2 {
            font-size: 1.5em; /* Set the font size for the subheading */
            margin-top: 0.2em; /* Slight space between the two headings */
        }
        .activities-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center; /* Center the container's content */
}

.activity-item {
    width: 150px; /* Set a fixed width for each activity item */
    height: 150px; /* Set a fixed height for each activity item */
    overflow: hidden;
    border-radius: 10px;
    border: 2px solid white;
    display: flex;
    justify-content: center;
    align-items: center;
}

.activity-image {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensure images cover the container without distortion */
}

</style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <img src="guardiandaycare.png" alt="Guardian Day Care" class="group-logo">
            <h1>Guardian Day Care</h1>
    
        </div>
        <div class="back-container">
            <button class="back-btn" onclick="location.href='parentdashboard.html'">Back</button>
        </div>
    </header>

    <nav class="navigation">
        <ul>
            <li><a href="display_activities.php">Children Activities Newsfeed</a></li> 
        </ul>    
    </nav>

    <h1>Children Activities Newsfeed</h1>
    <div class="activities-container">
        <?php include "fetch_activities.php";?> 
    </div>
    <script src="display_activities.js"></script>
</body>
</html>



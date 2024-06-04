<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guardian Day Care - Admin Dashboard</title>
    <link rel="stylesheet" href="educatordashboard.css"> <!-- Link to your main CSS file -->
    <link rel="stylesheet" href="notification.css"> <!-- Link to notification CSS file -->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        /* Styling for the first row */
        thead th {
            background-color: purple;
            color: white;
        }
         /* Styling for the first column */
         tbody {
            background-color: white;
            color: black;
        }
        
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <!-- Group Logo -->
            <img src="guardiandaycare.png" alt="Guardian Day Care" class="group-logo">
            <!-- Brand Logo -->
            <img src="brandtech.png" alt="BrandTech" class="brand-logo">
            <h1>Welcome to Guardian Day Care</h1>
            <h2>Admin Portal</h2>
        </div>
        <div class="logout-container">
            <button class="logout-btn" onclick="location.href='logout.php'">Logout</button>
        </div>
    </header>

    <nav class="navigation">
        <ul>
            <li><a href="fetch_contactus.php">Enquiries</a></li>
        </ul>
    </nav>

    <h2>Contact Enquiries</h2>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database connection parameters
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "project";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch data from the database, ordered by ID in descending order
            $sql = "SELECT name, email, description FROM ContactUs ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td><td>" . $row["description"] . "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No enquiries found</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>

</body>
</html>

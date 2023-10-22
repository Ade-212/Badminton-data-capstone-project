<?php include 'menu.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Task 2 - Club Members</title>
    <style>
        body {
            background-image: url('https://th.bing.com/th/id/OIP.e2xF-DPmBmFBEB124A_OTgHaEo?w=291&h=182&c=7&r=0&o=5&dpr=1.3&pid=1.7');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #ffffff;
            text-align: center;
            padding-top: 30px;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 20px auto;
            max-width: 600px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        li {
            padding: 12px;
            border-bottom: 1px solid #dddddd;
            color: #333333;
        }

        li:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <h1>Club Members</h1>
    <ul>

        <?php
        // Start or resume the session
        session_start();
        
        // Check if the user is not logged in, redirect to index.php
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            header('Location: index1.php');
            exit();
        }

        // Database connection parameters
        $db_host = "dragon.kent.ac.uk";
        $db_user = "co583";
        $db_password = "co583";
        $db_name = "co583";

        try {
            // Create a PDO connection to the database
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);

            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL query to get club name and total number of members
            $sql = "SELECT c.name AS club_name, COUNT(m.clubID) AS total_members
                    FROM club c
                    LEFT JOIN member m ON c.cid = m.clubID
                    GROUP BY c.cid
                    HAVING total_members >= 6";

            // Prepare the SQL query
            $stmt = $conn->prepare($sql);

            // Execute the query
            $stmt->execute();

            // Fetch all rows from the result set
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display the club names and total members in an unordered list
            foreach ($rows as $row) {
                echo "<li>{$row['club_name']} - Total Members: {$row['total_members']}</li>";
            }
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        // Close the database connection
        $conn = null;

        ?>

    </ul>
</body>
</html>

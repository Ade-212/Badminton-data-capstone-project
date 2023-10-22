<?php include 'menu.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Task 1 - Badminton Clubs</title>
    <style>
        /* CSS styleing for the page */
        body {
        background-image: url('https://th.bing.com/th/id/OIP.e2xF-DPmBmFBEB124A_OTgHaEo?w=220&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7');
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

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 30px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        border: 1px solid #dddddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #4CAF50;
        color: #ffffff;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    header {
            background-color: #4CAF50;
            padding: 15px;
            text-align: center;
            color: #ffffff;
            font-size: 24px;
        }

        /* animation: blinking text */
        @keyframes blinking {
            0%, 100% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
        }

        .blink-text {
            animation: blinking 1s infinite;
        }
    </style>
</head>
<body>
    <h1>Badminton Clubs</h1>
    <table>
        <tr>
            <th>Club ID</th>
            <th>Name</th>
            <th>Venue</th>
            <th>Extra details</th>
        </tr>

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

            // SQL query to retrieve club id, name, and venue of all clubs ordered by club ID
            $sql = "SELECT cid, name, venue, 'Additional Info' AS additional_info FROM club ORDER BY cid";

            // Prepare the SQL query
            $stmt = $conn->prepare($sql);

            // Execute the query
            $stmt->execute();

            // Fetch the data
            $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display the data in the table
            if (count($clubs) > 0) {
                foreach ($clubs as $club) {
                    echo "<tr>";
                    echo "<td>" . $club['cid'] . "</td>";
                    echo "<td>" . $club['name'] . "</td>";
                    echo "<td>" . $club['venue'] . "</td>";
                    echo "<td><a href='task3.php?cid=" . $club['cid'] . "'>View Details</a></td>"; // Link to task3.php
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No clubs found.</td></tr>";
            }
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        // Close the database connection
        $conn = null;
        ?>

    </table>
</body>
</html>

        
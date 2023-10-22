<?php include 'menu.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Task 3 - Club Details</title>
    <style>
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

        form {
            text-align: center;
            margin-top: 20px;
        }

        label, select, input[type="submit"] {
            font-size: 16px;
            padding: 5px;
            border: none;
            background-color: #4CAF50;
            color: #ffffff;
            border-radius: 5px;
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

        a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Club Details</h1>

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

        // SQL query to retrieve club details
        $sql = "SELECT cid, name, venue FROM club";

        // Prepare the SQL query
        $stmt = $conn->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch all rows from the result set
        $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Close the database connection
    $conn = null;
    ?>

    <!-- HTML form with the dropdown list -->
    <form action="task3.php" method="get">
        <label for="cid">Select a club:</label>
        <select name="cid" id="cid">
            <?php
            // Display club details in the dropdown list
            foreach ($clubs as $club) {
                echo "<option value='{$club['cid']}'>{$club['name']} - {$club['venue']}</option>";
            }
            ?>
        </select>
        <input type="submit" value="Submit">
    </form>

    <?php
    // Check if clubID is submitted via GET
    if (isset($_GET['cid'])) {
        // Get the selected clubID
        $selectedClubID = $_GET['cid'];

        try {
            // Create a new PDO connection to the database
            $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);

            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // SQL query to retrieve club details
            $clubSql = "SELECT cid, name, venue FROM club WHERE cid = :cid";

            // Prepare the SQL query
            $clubStmt = $conn->prepare($clubSql);

            // Bind the clubID parameter
            $clubStmt->bindParam(':cid', $selectedClubID);

            // Execute the query
            $clubStmt->execute();

            // Fetch the club details for the selected club
            $selectedClub = $clubStmt->fetch(PDO::FETCH_ASSOC);

            // Display the club details for the selected club
            if ($selectedClub) {
                echo "<h2>Selected Club Details:</h2>";
                echo "<p>Club ID: {$selectedClub['cid']}</p>";
                echo "<p>Name: {$selectedClub['name']}</p>";
                echo "<p>Venue: {$selectedClub['venue']}</p>";

                // SQL query to retrieve team details for the selected club
                $teamSql = "SELECT tid, category, division FROM team WHERE clubID = :cid ORDER BY category, division";

                // Prepare the SQL query
                $teamStmt = $conn->prepare($teamSql);

                // Bind the clubID parameter
                $teamStmt->bindParam(':cid', $selectedClubID);

                // Execute the query
                $teamStmt->execute();

                // Fetch all rows from the result set
                $teams = $teamStmt->fetchAll(PDO::FETCH_ASSOC);

                // Display the table with team details
                if (count($teams) > 0) {
                    echo "<h2>Team Details:</h2>";
                    echo "<table>";
                    echo "<tr><th>Team ID</th><th>Category</th><th>Division</th><th>Link to team</th><th>Link to club members</th></tr>";
                    foreach ($teams as $team) {
                        echo "<tr>";
                        echo "<td>{$team['tid']}</td>";
                        echo "<td>{$team['category']}</td>";
                        echo "<td>{$team['division']}</td>";
                        echo "<td><a href='task5.php?team={$team['tid']}'>View teams</a></td>"; // link to task5.php
                        echo "<td><a href='task4.php?club={$club['cid']}'>View members</a></td>"; // link to task4.php
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No teams found for this club.</p>";
                }
            } else {
                echo "<p>Selected club not found.</p>";
            }
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        // Close the database connection
        $conn = null;
    }
    ?>

</body>
</html>


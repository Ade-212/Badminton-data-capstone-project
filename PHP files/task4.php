<?php include 'menu.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Task 4 - Club Team Members</title>
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
    </style>
</head>
<body>
    <h1>Club Team Members</h1>

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

        // SQL query to retrieve club team member details
        $sql = "SELECT m.forename, m.surname, m.dob, m.gender, m.clubID
                FROM member m
                JOIN teamPlayer tp ON m.mid = tp.playerID
                ORDER BY m.clubID, m.surname, m.forename";

        // Prepare the SQL query
        $stmt = $conn->prepare($sql);

        // Execute the query
        $stmt->execute();

        // Fetch all rows from the result set
        $teamMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    // Close the database connection
    $conn = null;
    ?>

    <!-- Display the details of club team members in a table -->
    <table>
        <tr>
            <th>Forename</th>
            <th>Surname</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Club ID</th>
        </tr>

        <?php
        // Display team member details in the table
        foreach ($teamMembers as $member) {
            echo "<tr>";
            echo "<td>" . $member['forename'] . "</td>";
            echo "<td>" . $member['surname'] . "</td>";
            echo "<td>" . $member['dob'] . "</td>";
            echo "<td>" . $member['gender'] . "</td>";
            echo "<td>" . $member['clubID'] . "</td>";
            echo "</tr>";
        }
        ?>

    </table>

</body>
</html>

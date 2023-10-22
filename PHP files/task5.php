<?php include 'menu.php'; ?>
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

    // Retrieve the team parameter from the URL
    $teamID = $_GET['team'];

    // SQL query to retrieve match details and home team's venue
    $sql = "SELECT f.homeTeam, f.onDate, f.awayTeam, f.homeTeamScore, f.awayTeamScore, c.venue
            FROM fixture AS f
            INNER JOIN club AS c ON f.homeTeam = c.cid
            WHERE f.homeTeam = :teamID OR f.awayTeam = :teamID
            ORDER BY f.onDate";

    // Prepare the SQL query
    $stmt = $conn->prepare($sql);

    // Bind the teamID parameter
    $stmt->bindParam(':teamID', $teamID);

    // Execute the query
    $stmt->execute();

    // Fetch all rows from the result set
    $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task 5 - Team Match Details</title>
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
    </style>
</head>
<body>
    <h1>Team Match Details</h1>

    <?php
    if (count($matches) > 0) {
        echo "<table>";
        echo "<tr><th>Match ID</th><th>Date</th><th>Time</th><th>Opponent</th><th>Result</th><th>Division</th><th>Home Venue</th></tr>";
        foreach ($matches as $match) {
            echo "<tr>";
            echo "<td>{$match['matchID']}</td>";
            echo "<td>{$match['onDate']}</td>";
            echo "<td>{$match['time']}</td>";
            echo "<td>{$match['opponent']}</td>";
            echo "<td>{$match['result']}</td>";
            echo "<td>{$match['division']}</td>";
            echo "<td>{$match['venue']}</td>"; // Displaying home venue
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No matches found for this team.</p>";
    }
    ?>

    <!-- Link back to task3.php -->
    <p><a href="task3.php">Back to Club Details</a></p>
</body>
</html>

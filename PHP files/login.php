<?php
// Start of a new session
session_start();

// Define the correct username and password
$correctUsername = 't5';
$correctPassword = 'just4fun';

// Get the username and password submitted from the form
$username = $_POST['username'];
$password = $_POST['password'];

// Check if the submitted username & password are correct
if ($username === $correctUsername && $password === $correctPassword) {
    // Set session variable
    $_SESSION['loggedin'] = true;

    // Redirect to task1.php
    header('Location: task1.php');
    exit();
} else {
    // Display error message and link back to index.php
    echo "Incorrect username or password. <a href='index.php'>Back to login</a>";
}
?>

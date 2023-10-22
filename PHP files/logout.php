<?php
// Start or resume the session
session_start();

// If the user is logged in, destroy the session
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();
}

// Redirect to index1.php
header('Location: index1.php');
exit();
?>

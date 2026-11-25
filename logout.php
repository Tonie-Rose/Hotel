<?php
session_start();    // Start the session

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect to login or homepage
header("Location: index.php");
exit;

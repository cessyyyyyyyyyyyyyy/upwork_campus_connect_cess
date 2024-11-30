<?php
// logout.php
session_start(); // Start the session

// Destroy all session variables
session_unset();
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
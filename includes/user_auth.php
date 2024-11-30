<?php
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get logged-in user details
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type']; // Either 'client' or 'freelancer'
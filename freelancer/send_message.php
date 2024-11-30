<?php
session_start();

// Ensure that the logged-in user's ID is available in session
$sender_id = $_SESSION['user_id'];  // Logged-in user's ID from session
$receiver_id = $_POST['receiver_id']; // Receiver's ID from the form
$message = $_POST['message']; // Message content from the form

// Database connection
$conn = new mysqli('localhost', 'root', '', 'upwork_campus_connect_db'); // Update with your DB credentials

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert the message into the messages table
$sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
if ($conn->query($sql) === TRUE) {
    echo "Message sent!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

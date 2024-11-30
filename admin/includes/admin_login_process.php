<?php
require_once '../../includes/connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND user_type = 'admin'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password (adjust based on how you're storing passwords)
        if ($user['password'] === $password) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];

            // Redirect to admin dashboard
            header("Location: ../index.php");
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No admin account found with that email.";
    }

    $stmt->close();
    $conn->close();
}
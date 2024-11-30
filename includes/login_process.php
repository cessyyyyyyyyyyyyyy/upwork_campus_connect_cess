<?php
require_once 'connection.php';

// Start session to store logged-in user data
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check if email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = $user['user_type'];
            
            // Redirect based on user type
            if ($user['user_type'] === 'client') {
                header("Location: ../client/index.php");
            } elseif ($user['user_type'] === 'freelancer') {
                header("Location: ../freelancer/get_overview_data.php");
            } else {
                echo "Invalid user type.";
                exit();
            }
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }
}
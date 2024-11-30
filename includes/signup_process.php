<?php
require_once 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form input
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];
    $password_hashed = password_hash($password, PASSWORD_DEFAULT);

    $stmt_check = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt_check->bind_param("ss", $email, $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();


    if ($stmt_check->execute()) {
          $result_check = $stmt_check->get_result();
          if ($result_check->num_rows > 0) {
              echo "Email or username already exists.";
          } else {
              $stmt_insert = $conn->prepare("INSERT INTO users (first_name, last_name, username, email, password, user_type) VALUES (?, ?, ?, ?, ?, ?)");
              $stmt_insert->bind_param("ssssss", $first_name, $last_name, $username, $email, $password_hashed, $user_type);
              if ($stmt_insert->execute()) {
                  header("Location: ../login.php");
                  exit();
              } else {
                  echo "Error executing insert: " . $stmt_insert->error; // Log error if insert fails
              }
          }
      } else {
          echo "Error executing check query: " . $stmt_check->error;
      }
}
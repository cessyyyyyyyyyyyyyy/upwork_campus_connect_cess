<?php
require_once 'includes/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon">
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <title>Login - Upwork Campus Connect</title>
    <link rel="stylesheet" href="assets/css/index.css" />
  </head>
  <body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <img src="assets/logo.png" alt="logo" width="100" height="100">
          <span class="ms-2">Campus Connect</span>
        </a>
        <form class="d-flex ms-auto me-3">
          <input
            class="form-control me-2"
            type="search"
            placeholder="Search job"
            aria-label="Search"
          />
          <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
        <div>
          <a href="signup.php" class="btn btn-primary me-2">Signup</a>
          <a href="login.php" class="btn btn-outline-secondary">Login</a>
        </div>
      </div>
    </nav>

    <div
      class="container d-flex justify-content-center align-items-center vh-100"
    >
      <div class="card shadow p-4" style="width: 400px">
        <h3 class="text-center mb-4">Login</h3>
        <form action="includes/login_process.php" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="Enter your email"
              required
            />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              type="password"
              class="form-control"
              id="password"
              name="password"
              placeholder="Enter your password"
              required
            />
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary" name="login">Login</button>
          </div>
          <div class="text-center mt-3">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
          </div>
        </form>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

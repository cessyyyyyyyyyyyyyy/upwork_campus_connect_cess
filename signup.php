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
    <title>Sign Up - Upwork Campus Connect</title>
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
      <div class="card shadow p-4" style="width: 500px">
        <h3 class="text-center mb-4">Sign Up</h3>
        <form action="includes/signup_process.php" method="POST">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="first_name" class="form-label">First Name</label>
              <input
                type="text"
                class="form-control"
                id="first_name"
                name="first_name"
                placeholder="First Name"
                required
              />
            </div>
            <div class="col-md-6">
              <label for="last_name" class="form-label">Last Name</label>
              <input
                type="text"
                class="form-control"
                id="last_name"
                name="last_name"
                placeholder="Last Name"
                required
              />
            </div>
          </div>
          <div class="mb-3 mt-3">
            <label for="username" class="form-label">Username</label>
            <input
              type="text"
              class="form-control"
              id="username"
              name="username"
              placeholder="Create a username"
              required
            />
          </div>
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
              placeholder="Create a password"
              required
            />
          </div>
          <div class="mb-3">
            <label for="user_type" class="form-label">I am a</label>
            <select
              class="form-select"
              id="user_type"
              name="user_type"
              required
            >
              <option value="" selected disabled>Select an option</option>
              <option value="client">Client</option>
              <option value="freelancer">Freelancer</option>
            </select>
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
          </div>
          <div class="text-center mt-3">
            <p>Already have an account? <a href="login.php">Login</a></p>
          </div>
        </form>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

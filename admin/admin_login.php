<?php
require_once '../includes/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="../assets/logo-placeholder-white.svg"
      type="image/x-icon"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <title>Admin Login - Upwork Campus Connect</title>
    <link rel="stylesheet" href="../assets/css/resets.css" />
  </head>
  <body>
    <div
      class="container d-flex justify-content-center align-items-center vh-100"
    >
      <div class="card shadow p-4" style="width: 400px">
        <h3 class="text-center mb-4">Admin Login</h3>
        <form action="includes/admin_login_process.php" method="POST">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              type="email"
              class="form-control"
              id="email"
              name="email"
              placeholder="Enter your admin email"
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
              placeholder="Enter your admin password"
              required
            />
          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary" name="login">
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

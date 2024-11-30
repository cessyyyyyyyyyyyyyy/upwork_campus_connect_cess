<?php

try {
  $dsn = 'mysql:host=localhost;dbname=upwork_campus_connect_db;charset=utf8mb4';
  $username = 'root';
  $password = '';
 

  // Create a PDO instance
  $pdo = new PDO($dsn, $username, $password);

  // Set error mode to exception for better debugging
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}


// Include the database connection
require_once '../includes/connection.php';

try {
    // Fetch all users excluding admins if needed
    $query = "SELECT user_id, first_name, last_name, email, user_type FROM users WHERE user_type = 'client'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Error fetching users: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/logo-placeholder-white.svg" type="image/x-icon" />
    <title>Manage Users - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/resets.css" />
    <link rel="stylesheet" href="../assets/css/sidebar.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 sidebar bg-dark text-white d-none d-md-block">
        <img
  src="../img/logo.png"
  alt="Logo"
  class="logo mb-4"
/>
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link active" href="manage-users.php">Manage Users</a></li>
            <li class="nav-item"><a class="nav-link" href="manage-freelancers.php">Manage Freelancers</a></li>
            <li class="nav-item"><a class="nav-link" href="manage-jobs.php">Manage Jobs</a></li>
            <li class="nav-item"><a class="nav-link" href="settings.php">Settings</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Logout</a></li>
          </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 p-4">
          <h1 class="mb-4">Manage Users</h1>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $index => $user): ?>
                  <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo ucfirst(htmlspecialchars($user['user_type'])); ?></td>
                    <td>
                      <a href="edit-user.php?id=<?php echo $user['user_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                      <button class="btn btn-danger btn-sm" disabled>Delete</button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </main>
      </div>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

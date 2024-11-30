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

$freelancers = []; // Initialize as an empty array in case the query fails

try {
    // Check if the connection is set
    if (isset($pdo)) {
        $query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS name, email 
                  FROM users 
                  WHERE user_type = 'freelancer'";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $freelancers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "Database connection failed!";
        exit; // Stop execution if the connection fails
    }
} catch (PDOException $e) {
    echo "Error fetching freelancers: " . $e->getMessage();
    exit;
}
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
    <title>Manage Freelancers - Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/resets.css" />
    <link rel="stylesheet" href="../assets/css/sidebar.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-3 col-lg-2 sidebar bg-dark text-white d-none d-md-block" id="desktop-sidebar">
        <img
  src="../img/logo.png"
  alt="Logo"
  class="logo mb-4"
/>

          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="manage-users.php">Manage Users</a></li>
            <li class="nav-item"><a class="nav-link active" href="manage-freelancers.php">Manage Freelancers</a></li>
            <li class="nav-item"><a class="nav-link" href="manage-jobs.php">Manage Jobs</a></li>
            <li class="nav-item"><a class="nav-link" href="settings.php">Settings</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Logout</a></li>
          </ul>
        </nav>

        <main class="col-md-9 col-lg-10 p-4">
          <h1 class="mb-4">Manage Freelancers</h1>
          <?php if (!empty($freelancers)): ?>
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($freelancers as $index => $freelancer): ?>
                  <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($freelancer['name']); ?></td>
                    <td><?php echo htmlspecialchars($freelancer['email']); ?></td>
                    <td>
                      <button class="btn btn-warning btn-sm">Edit</button>
                      <button class="btn btn-danger btn-sm">Delete</button>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p>No freelancers found!</p>
          <?php endif; ?>
        </main>
      </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

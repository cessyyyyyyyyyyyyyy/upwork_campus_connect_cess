<?php
session_start();

// Check if the user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: admin_login.php");
    exit();
}

// Include the database connection file (replace with your own connection logic)
require_once '../includes/connection.php';

// Database connection variables
$db_host = 'localhost';          // Hostname of the database (typically 'localhost' for local setups)
$db_username = 'root';           // Username for the database (change if necessary)
$db_password = '';               // Password for the database (empty by default for local XAMPP setups)
$db_name = 'upwork_campus_connect_db'; // Your database name

// Create a connection to the database
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Make sure your database connection works
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the total number of users
$user_count_query = "SELECT COUNT(*) AS total_users FROM users";
$user_count_result = mysqli_query($conn, $user_count_query);
$user_count = mysqli_fetch_assoc($user_count_result)['total_users'];

// Get the total number of freelancers
$freelancer_count_query = "SELECT COUNT(*) AS total_freelancers FROM freelancers";
$freelancer_count_result = mysqli_query($conn, $freelancer_count_query);
$freelancer_count = mysqli_fetch_assoc($freelancer_count_result)['total_freelancers'];

// Get the total number of jobs posted
$job_count_query = "SELECT COUNT(*) AS total_jobs FROM jobs";
$job_count_result = mysqli_query($conn, $job_count_query);
$job_count = mysqli_fetch_assoc($job_count_result)['total_jobs'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="shortcut icon" href="img/logo.jpg" type="image/x-icon" />
  <title>Admin Dashboard - Upwork Campus Connect</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../assets/css/resets.css" />
  <link rel="stylesheet" href="../assets/css/sidebar.css" />
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-3 col-lg-2 sidebar bg-dark text-white d-none d-md-block">
        <img src="../img/logo.png" alt="Logo" class="logo mb-4" />
        <ul class="nav flex-column">
          <li class="nav-item"><a class="nav-link active" href="index.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="manage-users.php">Manage Users</a></li>
          <li class="nav-item"><a class="nav-link" href="manage-freelancers.php">Manage Freelancers</a></li>
          <li class="nav-item"><a class="nav-link" href="manage-jobs.php">Manage Jobs</a></li>
          <li class="nav-item"><a class="nav-link" href="settings.php">Settings</a></li>
          <li class="nav-item"><a class="nav-link" href="../login.php">Logout</a></li>
        </ul>
      </nav>

      <main class="col-md-9 col-lg-10 p-4">
        <h1 class="mb-4">Admin Dashboard</h1>
        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary">
              <div class="card-header">Total Users</div>
              <div class="card-body">
                <h5 class="card-title"><?php echo $user_count; ?></h5>
                <p class="card-text">This is the total number of users on the platform.</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-3">
            <div class="card text-white bg-success">
              <div class="card-header">Total Freelancers</div>
              <div class="card-body">
                <h5 class="card-title"><?php echo $freelancer_count; ?></h5>
                <p class="card-text">This is the total number of freelancers registered.</p>
              </div>
            </div>
          </div>

          <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning">
              <div class="card-header">Total Jobs Posted</div>
              <div class="card-body">
                <h5 class="card-title"><?php echo $job_count; ?></h5>
                <p class="card-text">This is the total number of jobs posted on the platform.</p>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>

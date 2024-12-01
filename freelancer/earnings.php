<?php
require_once '../includes/connection.php';
require_once '../includes/user_auth.php';

// For debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// SQL query to fetch total earnings
$total_earnings_sql = "SELECT SUM(amount) AS total_earnings FROM payments WHERE paid_at IS NOT NULL";
$total_earnings_result = $conn->query($total_earnings_sql);
$total_earnings = 0;

if ($total_earnings_result && $total_earnings_result->num_rows > 0) {
    $total_row = $total_earnings_result->fetch_assoc();
    $total_earnings = $total_row['total_earnings'];
}

// SQL query to fetch withdrawable earnings (just based on paid_at as example)
$withdrawable_earnings_sql = "SELECT SUM(amount) AS withdrawable_earnings FROM payments WHERE paid_at IS NOT NULL";
$withdrawable_earnings_result = $conn->query($withdrawable_earnings_sql);
$withdrawable_earnings = 0;

if ($withdrawable_earnings_result && $withdrawable_earnings_result->num_rows > 0) {
    $withdrawable_row = $withdrawable_earnings_result->fetch_assoc();
    $withdrawable_earnings = $withdrawable_row['withdrawable_earnings'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <title>Earnings - Upwork Campus Connect</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/sidebar.css" />
    <link rel="stylesheet" href="../assets/css/resets.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
        <?php include('includes/sidebar.php'); ?>

        <!-- Mobile Navbar (Visible on mobile) -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-md-none">
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="get_overview_data.php">Overview</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="notifications.php">Notifications</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="active-jobs.php">Active Jobs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="post-job.php">Post a Job</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="earnings.php">Earnings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="freelancer_message">Message</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Logout</a>
              </li>
            </ul>
          </div>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10">
          <h1 class="my-4">Earnings</h1>

          <div class="row">
            <!-- Total Earnings -->
            <div class="col-md-6 mb-3">
              <div class="card text-white bg-primary">
                <div class="card-header">Total Earnings</div>
                <div class="card-body">
                  <h5 class="card-title">₱<?php echo number_format($total_earnings, 2); ?></h5>
                  <p class="card-text">
                    This is the total amount you've earned so far.
                  </p>
                </div>
              </div>
            </div>

            <!-- Withdrawable Earnings -->
            <div class="col-md-6 mb-3">
              <div class="card text-white bg-success">
                <div class="card-header">Withdrawable Earnings</div>
                <div class="card-body">
                  <h5 class="card-title">₱<?php echo number_format($withdrawable_earnings, 2); ?></h5>
                  <p class="card-text">
                    This is the amount available for withdrawal.
                  </p>
                </div>
              </div>
            </div>
          </div>

        
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

<?php
// Close the database connection
$conn->close();
?>

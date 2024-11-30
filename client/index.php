<?php
require_once '../includes/connection.php';
require_once '../includes/user_auth.php';

// Fetch user details
$user_query = "SELECT username, email FROM users WHERE user_id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

// Fetch overview data
$completed_query = "SELECT COUNT(*) AS completed_count FROM projects WHERE client_id = ? AND status = 'completed'";
$stmt = $conn->prepare($completed_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$completed_result = $stmt->get_result();
$completed = $completed_result->fetch_assoc()['completed_count'];
$stmt->close();

$ongoing_query = "SELECT COUNT(*) AS ongoing_count FROM projects WHERE client_id = ? AND status = 'ongoing'";
$stmt = $conn->prepare($ongoing_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$ongoing_result = $stmt->get_result();
$ongoing = $ongoing_result->fetch_assoc()['ongoing_count'];
$stmt->close();

$pending_query = "SELECT SUM(amount_paid) AS pending_total FROM projects WHERE client_id = ? AND payment_status = 'unpaid'";
$stmt = $conn->prepare($pending_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$pending_result = $stmt->get_result();
$pending = $pending_result->fetch_assoc()['pending_total'] ?: 0;
$stmt->close();

$total_spent_query = "SELECT SUM(amount) AS total_spent FROM payments WHERE client_id = ?";
$stmt = $conn->prepare($total_spent_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total_spent_result = $stmt->get_result();
$total_spent = $total_spent_result->fetch_assoc()['total_spent'] ?: 0;
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
      href="img/logo.png"
      type="image/x-icon"
    />
    <title>Upwork Campus Connect</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/sidebar.css" />
    <link rel="stylesheet" href="../assets/css/resets.css" />
    <link rel="stylesheet" href="css/job-listings.css" />
    <link rel="stylesheet" href="../assets/css/overview.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <?php include('includes/sidebar.php'); ?>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 p-0">
          <!-- Overview Section -->
          <section class="overview-page p-4">
              <div class='user-info mb-4'>
                  <p class='text-gray'>Welcome, <?php echo $user['username']; ?>!</p>
                  <p class='text-muted small'><?php echo $user['email']; ?></p>
              </div>

              <h1 class="mb-4">Overview</h1>
              <div class="row g-4">
                  <!-- Completed Projects Card -->
                  <div class="col-md-6 col-lg-3">
                      <div class="card shadow-sm border-primary">
                          <div class="card-body text-center">
                              <h5 class="card-title text-primary">Completed Projects</h5>
                              <p class="card-text"><?php echo $completed; ?></p>
                          </div>
                      </div>
                  </div>

                  <!-- Ongoing Projects Card -->
                  <div class="col-md-6 col-lg-3">
                      <div class="card shadow-sm border-success">
                          <div class="card-body text-center">
                              <h5 class="card-title text-success">Ongoing Projects</h5>
                              <p class="card-text"><?php echo $ongoing; ?></p>
                          </div>
                      </div>
                  </div>

                  <!-- Pending Payments Card -->
                  <div class="col-md-6 col-lg-3">
                      <div class="card shadow-sm border-warning">
                          <div class="card-body text-center">
                              <h5 class="card-title text-warning">Pending Payments</h5>
                              <p class="card-text">₱<?php echo number_format($pending, 2); ?></p>
                          </div>
                      </div>
                  </div>

                  <!-- Total Spent Card -->
                  <div class="col-md-6 col-lg-3">
                      <div class="card shadow-sm border-info">
                          <div class="card-body text-center">
                              <h5 class="card-title text-info">Total Spent</h5>
                              <p class="card-text">₱<?php echo number_format($total_spent, 2); ?></p>
                          </div>
                      </div>
                  </div>
              </div>
          </section>
        </main>
      </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

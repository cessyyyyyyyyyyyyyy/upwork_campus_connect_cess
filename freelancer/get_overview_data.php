<?php
require_once '../includes/connection.php';
require_once '../includes/user_auth.php';

// Validate that $user_id is defined
if (!isset($user_id)) {
    die("Error: User is not authenticated.");
}

// Fetch user details and user type
$user_query = "SELECT username, email, user_type FROM users WHERE user_id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

// Validate $user result
if (!$user) {
    die("Error: User not found.");
}

// Check if user is a client or freelancer
if ($user['user_type'] === 'client') {
    // Fetch data for clients
    $completed_query = "SELECT COUNT(*) AS completed_count FROM projects WHERE client_id = ? AND status = 'completed'";
    $stmt = $conn->prepare($completed_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $completed_result = $stmt->get_result();
    $completed = $completed_result ? $completed_result->fetch_assoc()['completed_count'] : 0;
    $stmt->close();

    $pending_query = "SELECT SUM(amount) AS pending_total FROM payments WHERE client_id = ? AND status = 'pending'";
    $stmt = $conn->prepare($pending_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $pending_result = $stmt->get_result();
    $pending = $pending_result ? $pending_result->fetch_assoc()['pending_total'] : 0;
    $stmt->close();

} elseif ($user['user_type'] === 'freelancer') {
    // Fetch data for freelancers
    $completed_query = "SELECT COUNT(*) AS completed_count FROM projects WHERE freelancer_id = ? AND status = 'completed'";
    $stmt = $conn->prepare($completed_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $completed_result = $stmt->get_result();
    $completed = $completed_result ? $completed_result->fetch_assoc()['completed_count'] : 0;
    $stmt->close();

    $ongoing_query = "SELECT COUNT(*) AS ongoing_count FROM projects WHERE freelancer_id = ? AND status = 'ongoing'";
    $stmt = $conn->prepare($ongoing_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $ongoing_result = $stmt->get_result();
    $ongoing = $ongoing_result ? $ongoing_result->fetch_assoc()['ongoing_count'] : 0;
    $stmt->close();

    $pending_query = "SELECT SUM(amount) AS pending_total FROM payments WHERE freelancer_id = ? AND status = 'pending'";
    $stmt = $conn->prepare($pending_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $pending_result = $stmt->get_result();
    $pending = $pending_result ? $pending_result->fetch_assoc()['pending_total'] : 0;
    $stmt->close();

   // SQL query to fetch total earnings
$total_earnings_sql = "SELECT SUM(amount) AS total_earnings FROM payments WHERE paid_at IS NOT NULL";
$total_earnings_result = $conn->query($total_earnings_sql);
$total_earnings = 0;

if ($total_earnings_result && $total_earnings_result->num_rows > 0) {
    $total_row = $total_earnings_result->fetch_assoc();
    $total_earnings = $total_row['total_earnings'];
}
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <title>Freelancer Overview - Upwork Campus Connect</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/overview.css" />
    <link rel="stylesheet" href="css/sidebar.css" />
    <link rel="stylesheet" href="../assets/css/resets.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar -->
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
        <?php if ($user['user_type'] === 'client'): ?>
            <!-- Client-specific cards -->
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Completed Projects</h5>
                        <p class="card-text"><?php echo $completed; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-warning">
                    <div class="card-body text-center">
                        <h5 class="card-title text-warning">Pending Payments</h5>
                        <p class="card-text">₱<?php echo number_format($pending, 2); ?></p>
                    </div>
                </div>
            </div>
        <?php elseif ($user['user_type'] === 'freelancer'): ?>
            <!-- Freelancer-specific cards -->
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-primary">
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary">Completed Projects</h5>
                        <p class="card-text"><?php echo $completed; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-success">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success">Active Jobs</h5>
                        <p class="card-text"><?php echo $ongoing; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-warning">
                    <div class="card-body text-center">
                        <h5 class="card-title text-warning">Pending Payments</h5>
                        <p class="card-text">₱<?php echo number_format($pending, 2); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card shadow-sm border-info">
                    <div class="card-body text-center">
                        <h5 class="card-title text-info">Total Earned</h5>
                        <p class="card-text">₱<?php echo number_format($total_earnings, 2); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>                               
</section>

        </main>
      </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

  
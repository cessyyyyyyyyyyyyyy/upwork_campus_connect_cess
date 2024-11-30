<?php
require_once '../includes/connection.php';
require_once '../includes/user_auth.php';

// For debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// SQL query to fetch payment data and related project and service details
$sql = "
    SELECT 
        p.payment_id,
        p.project_id,
        p.client_id,
        p.freelancer_id,
        p.amount,
        p.paid_at,
        prj.project_id, 
        prj.job_id,
        prj.status AS project_status,
        prj.started_at, 
        prj.completed_at, 
        prj.amount_paid, 
        prj.payment_status, 
        pr.title AS service_name,  -- Correctly fetch the service name
        CONCAT(c.first_name, ' ', c.last_name) AS client_name,
        CONCAT(f.first_name, ' ', f.last_name) AS freelancer_name
    FROM payments p
    LEFT JOIN projects prj ON p.project_id = prj.project_id
    LEFT JOIN users c ON prj.client_id = c.user_id
    LEFT JOIN users f ON prj.freelancer_id = f.user_id
    LEFT JOIN services pr ON pr.service_id = prj.job_id  -- Ensuring job_id maps to service_id
    ORDER BY prj.started_at DESC, p.payment_id DESC
";

// Execute the query and fetch the result
$result = $conn->query($sql);

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
    <title>Payments - Upwork Campus Connect</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/resets.css" />
    <link rel="stylesheet" href="../assets/css/sidebar.css" />
    <link rel="stylesheet" href="css/payments.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <?php include('includes/sidebar.php'); ?>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10">
          <!-- Payments Section -->
          <section class="overview-page">
            <h1>Payments</h1>

            <!-- Payments Table -->
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Payment ID</th>
                    <th>Service</th>
                    <th>Client Name</th>
                    <th>Freelancer Name</th>
                    <th>Amount</th>
                    <th>Paid At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                  <?php while($payment = $result->fetch_assoc()): ?>
                    <tr>
                      <td><?php echo htmlspecialchars($payment['payment_id']); ?></td>
                      <td><?php echo htmlspecialchars($payment['service_name']); ?></td> <!-- Display service name -->
                      <td><?php echo htmlspecialchars($payment['client_name']); ?></td>
                      <td><?php echo htmlspecialchars($payment['freelancer_name']); ?></td>
                      <td><?php echo "₱" . number_format($payment['amount'], 2); ?></td>
                      <td>
                          <?php 
                          if ($payment['paid_at'] === NULL) {
                              echo "<span class='text-warning'>Pending</span>"; // Show 'Pending' if payment hasn't been made
                          } else {
                              echo htmlspecialchars($payment['paid_at']); // Display the actual payment date if available
                          }
                          ?>
                      </td>
                      <td>
                        <?php if ($payment['paid_at'] === NULL): ?>
                            <form action="manage-projects.php" method="POST">
                                <input type="hidden" name="project_id" value="<?php echo $payment['project_id']; ?>">
                                <input type="hidden" name="payment_status" value="paid">
                                <button type="submit" name="pay_now" class="btn btn-success">Pay Now</button>
                            </form>
                        <?php else: ?>
                            <span class="text-success">Paid</span>
                        <?php endif; ?>
                    </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="7">No payments found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
              </table>
            </div>
          </section>
        </main>
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

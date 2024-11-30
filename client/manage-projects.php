<?php
require_once '../includes/connection.php';
require_once '../includes/user_auth.php';
// For debugging purposes
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Query to fetch projects for the logged-in user
$query = "
    SELECT 
        p.project_id, p.status, p.started_at, p.completed_at, p.cancelled_at, 
        s.title AS project_title, 
        CONCAT(u.first_name, ' ', u.last_name) AS freelancer_name, 
        p.review_left, p.payment_status, p.amount_paid
    FROM projects p
    JOIN services s ON p.job_id = s.service_id
    JOIN users u ON p.freelancer_id = u.user_id
    WHERE p.client_id = $user_id
    ORDER BY p.started_at DESC
";

$result = mysqli_query($conn, $query);

// Check if the query is successful
if (!$result) {
    die("Error fetching projects: " . mysqli_error($conn));
}

// Update project status when form is submitted
if (isset($_POST['update_status'])) {
    $project_id = $_POST['project_id'];
    $new_status = $_POST['status'];

    // Initialize the completed_at and cancelled_at variables
    $completed_at = "";
    $cancelled_at = "";

    // Check if the status is 'completed'
    if ($new_status == 'completed') {
        $completed_at = ", completed_at = NOW()";  // Set completed_at to current timestamp
    } elseif ($new_status == 'cancelled') {
        $cancelled_at = ", cancelled_at = NOW()";  // Set cancelled_at to current timestamp
        // Optionally, you can display a message reminding the user that they can leave a review after cancellation.
    }

    // Query to update the project status and possibly completed_at or cancelled_at
    $update_query = "
        UPDATE projects
        SET status = '$new_status'
        $completed_at
        $cancelled_at
        WHERE project_id = $project_id
    ";

    if (mysqli_query($conn, $update_query)) {
        // Optionally, add logic to remind them to leave a review after cancellation
        if ($new_status == 'cancelled') {
            // Show message or reminder to leave a review later
        }
        // Reload the page after success
        header("Location: manage-projects.php");
        exit(); // Make sure to stop the script here
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}


// Add review and update the review_left flag
if (isset($_POST['leave_review'])) {
    $project_id = $_POST['project_id'];
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    // Update review and mark review_left as 1 (true)
    $query = "UPDATE projects SET review = '$review', review_left = 1 WHERE project_id = $project_id";

    if (mysqli_query($conn, $query)) {
        echo "<div class='alert alert-success'>Review submitted successfully!</div>";
        // Optionally, reload the page or redirect
        header("Location: manage-projects.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}

if (isset($_POST['pay_now'])) {
    $project_id = $_POST['project_id'];
    $payment_status = $_POST['payment_status'];

    // Update the payment status and paid_at timestamp in the payments table
    $update_payment_query = "
        UPDATE payments
        SET paid_at = NOW()
        WHERE project_id = $project_id
    ";

    if (mysqli_query($conn, $update_payment_query)) {
        // Update the project table's payment status
        $update_project_query = "
            UPDATE projects
            SET payment_status = 'paid'
            WHERE project_id = $project_id
        ";

        if (mysqli_query($conn, $update_project_query)) {
            echo "<div class='alert alert-success'>Payment status updated successfully!</div>";
            // Reload the page to reflect changes
            header("Location: manage-projects.php");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error updating project status: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error updating payment status: " . mysqli_error($conn) . "</div>";
    }
}
// Update project status when form is submitted
if (isset($_POST['update_status'])) {
  $project_id = $_POST['project_id'];
  $new_status = $_POST['status'];

  // Initialize the completed_at and cancelled_at variables
  $completed_at = "";
  $cancelled_at = "";

  // Check if the status is 'completed'
  if ($new_status == 'completed') {
      $completed_at = ", completed_at = NOW()";  // Set completed_at to current timestamp
  } elseif ($new_status == 'cancelled') {
      $cancelled_at = ", cancelled_at = NOW()";  // Set cancelled_at to current timestamp
  }

  // Ensure $update_query is always set
  $update_query = "
      UPDATE projects
      SET status = '$new_status'
      $completed_at
      $cancelled_at
      WHERE project_id = $project_id
  ";

  // Check if the query is not empty before running it
  if (!empty($update_query)) {
      if (mysqli_query($conn, $update_query)) {
          $_SESSION['notification'] = "Project status updated successfully!";
          header("Location: manage-projects.php");
          exit();
      } else {
          $_SESSION['notification'] = "Error updating project status: " . mysqli_error($conn);
      }
  } else {
      $_SESSION['notification'] = "Invalid query.";
  }
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon" />
    <title>Manage Projects - Upwork Campus Connect</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/resets.css" />
    <link rel="stylesheet" href="../assets/css/sidebar.css" />
    <link rel="stylesheet" href="css/manage-projects.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <?php include('includes/sidebar.php'); ?>

        <main class="col-md-9 col-lg-10">
          <section class="overview-page">
            <h1>Manage Projects</h1>
            <?php if (mysqli_num_rows($result) == 0): ?>
              <div class="alert alert-info">
                You have no projects added yet.
              </div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Project Title</th>
                      <th>Status</th>
                      <th>Freelancer</th>
                      <th>Start Date</th>
                      <th>Completion Date</th>
                      <th>Cancellation Date</th>
                      <th>Payment</th>
                      <th>Actions</th>
                      <th>Leave a Review</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($row['project_title']); ?></td>
                        <td>
                          <?php 
                            // Display the appropriate badge based on the status
                            switch ($row['status']) {
                              case 'ongoing':
                                echo '<span class="badge bg-warning text-dark">In Progress</span>';
                                break;
                              case 'completed':
                                echo '<span class="badge bg-success">Completed</span>';
                                break;
                              case 'cancelled':
                                echo '<span class="badge bg-danger">Cancelled</span>';
                                break;
                            }
                          ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['freelancer_name']); ?></td>
                        <td><?php echo date('M, d, Y', strtotime($row['started_at'])); ?></td>
                        <td><?php echo $row['completed_at'] ? date('M, d, Y', strtotime($row['completed_at'])) : 'N/A'; ?></td>
                        <td><?php echo $row['cancelled_at'] ? date('M, d, Y', strtotime($row['cancelled_at'])) : 'N/A'; ?></td>
                        <td>
                          <?php 
                            if ($row['payment_status'] == 'paid') {
                              echo '<span class="badge bg-success">Paid</span> - ₱' . number_format($row['amount_paid'], 2);
                            } elseif ($row['payment_status'] == 'pending') {
                              echo '<span class="badge bg-warning">Pending</span> - ₱' . number_format($row['amount_paid'], 2);
                            } else {
                              echo '<span class="badge bg-danger">Unpaid</span> - ₱' . number_format($row['amount_paid'], 2);
                            }
                          ?>
                        </td>
                          <td>
                          <form action="manage-projects.php" method="post">
                            <input type="hidden" name="project_id" value="<?php echo $row['project_id']; ?>">
                            <select name="status" class="form-select" <?php echo ($row['status'] == 'completed' || $row['status'] == 'cancelled') ? 'disabled' : ''; ?>>
                              <option value="ongoing" <?php echo ($row['status'] == 'ongoing') ? 'selected' : ''; ?>>In Progress</option>
                              <option value="completed" <?php echo ($row['status'] == 'completed') ? 'selected' : ''; ?>>Completed</option>
                              <option value="cancelled" <?php echo ($row['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <?php if ($row['status'] != 'completed' && $row['status'] != 'cancelled'): ?>
                              <button type="submit" name="update_status" class="btn btn-sm btn-primary mt-2">Update Status</button>
                            <?php endif; ?>
                          </form>
                        </td>
                        <td>
                          <?php if ($row['status'] == 'completed' && $row['review_left'] == 0): ?>
                            <a href="freelancer_review.php?project_id=<?php echo $row['project_id']; ?>" class="btn btn-primary">Leave a Review</a>
                          <?php elseif ($row['status'] == 'completed' && $row['review_left'] == 1): ?>
                            <span class="text-success">Review Left</span>
                          <?php elseif ($row['status'] == 'cancelled' && $row['review_left'] == 0): ?>
                            <a href="freelancer_review.php?project_id=<?php echo $row['project_id']; ?>" class="btn btn-warning">Leave a Review (Cancelled)</a>
                          <?php else: ?>
                            <span class="text-muted">N/A</span>
                          <?php endif; ?>
                        </td>
                        
                      </tr>
                    <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </section>

        </main>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
    <script>
      const statusSelect = document.querySelectorAll('select[name="status"]');
      statusSelect.forEach(select => {
          select.addEventListener('change', function() {
              if (this.value === 'completed') {
                  const confirmation = confirm('Are you sure? Once marked as completed, the project cannot be changed.');
                  if (!confirmation) {
                      this.value = 'ongoing';  // Revert back to "ongoing" if the user cancels
                  }
              } else if (this.value === 'cancelled') {
                  const confirmation = confirm('Are you sure? Once cancelled, you can leave a review and update later.');
                  if (!confirmation) {
                      this.value = 'ongoing';  // Revert back to "ongoing" if the user cancels
                  }
              }
          });
      });
    </script>

  </body>
</html>

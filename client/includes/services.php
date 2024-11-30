<?php
require_once '../includes/connection.php';
require_once '../includes/user_auth.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<div class='alert alert-danger'>You must be logged in to apply for a service.</div>";
    exit();
}

// Get the logged-in client's ID
$client_id = $_SESSION['user_id'];

// Check if the user has clicked the "Apply" button to add a service to a project
if (isset($_POST['apply_service'])) {
    $service_id = intval($_POST['service_id']);
    $freelancer_id = intval($_POST['freelancer_id']);
    $status = 'ongoing'; // Default status when a project is created
    $started_at = date('Y-m-d H:i:s');
    $payment_status = 'unpaid'; // Default payment status
    $service_price = $_POST['price'];

    // Sanitize inputs to prevent SQL injection
    $service_id = mysqli_real_escape_string($conn, $service_id);
    $freelancer_id = mysqli_real_escape_string($conn, $freelancer_id);

    // Check if the service is already applied by this client, excluding completed or cancelled projects
    $check_query = "
        SELECT * FROM projects 
        WHERE client_id = '$client_id' AND job_id = '$service_id' 
        AND (status != 'completed' AND status != 'cancelled')
    ";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<div class='alert alert-warning'>You have already applied for this service.</div>";
    } else {
        // Insert a new project
        $insert_project_query = "
            INSERT INTO projects 
            (client_id, freelancer_id, job_id, status, started_at, payment_status, amount_paid) 
            VALUES 
            ('$client_id', '$freelancer_id', '$service_id', '$status', '$started_at', '$payment_status', '$service_price')
        ";

        if (mysqli_query($conn, $insert_project_query)) {
            // Get the last inserted project ID to associate with the payment
            $project_id = mysqli_insert_id($conn);

            // Insert a new payment record
            $insert_payment_query = "
                INSERT INTO payments 
                (project_id, client_id, freelancer_id, amount, paid_at) 
                VALUES 
                ('$project_id', '$client_id', '$freelancer_id', '$service_price', NULL)
            ";

            if (mysqli_query($conn, $insert_payment_query)) {
                echo "<div class='alert alert-success'>Project and payment record created successfully.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error creating payment record: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Error creating project: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Fetch services from the database
$query = "
    SELECT s.service_id, s.title, s.description, s.price, u.first_name, u.last_name, s.created_at, s.freelancer_id
    FROM services s
    JOIN users u ON s.freelancer_id = u.user_id
    WHERE u.user_type = 'freelancer'
    ORDER BY s.created_at DESC LIMIT 3
";
$result = mysqli_query($conn, $query);

// Debugging: Check if query is successful
if (!$result) {
    echo "<div class='alert alert-danger'>Error fetching services: " . mysqli_error($conn) . "</div>";
    exit();
}


if (mysqli_num_rows($result) === 0) {
  echo "<div class='alert alert-info'>No services available at the moment.</div>";
}

// Debugging: Check if any services are returned
if (mysqli_num_rows($result) === 0) {
    echo "<div class='alert alert-info'>No services available at the moment.</div>";
}

if (!$result || mysqli_num_rows($result) === 0) {
  echo "
      <div class='alert alert-info text-center'>
          <p>No services are available at the moment. Please check back later or post a job.</p>
      </div>
  ";
  exit();
}

?>

<!-- Services Offered Section -->
<section class="py-5">
  <div class="container">
    <h3 class="text-center mb-4">Services Offered</h3>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="col">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
              <ul class="list-unstyled">
                <li><strong>Freelancer:</strong> <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></li>
                <li><strong>Price:</strong> ₱<?php echo number_format($row['price'], 2); ?></li>
                <li><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></li>
              </ul>
              <p class="text-muted">
                <small>Posted: <?php echo htmlspecialchars($row['created_at']); ?></small>
              </p>
              <!-- Add to Project Button -->
              <form action="services.php" method="post">
                <input type="hidden" name="service_id" value="<?php echo htmlspecialchars($row['service_id']); ?>">
                <input type="hidden" name="freelancer_id" value="<?php echo htmlspecialchars($row['freelancer_id']); ?>">
                <input type="hidden" name="price" value="<?php echo htmlspecialchars($row['price']); ?>">
                <button type="submit" name="apply_service" class="btn btn-primary w-100">Apply</button>
              </form>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php
// Display notifications if available
if (isset($_SESSION['notification'])) {
    echo "<div class='alert alert-info'>" . $_SESSION['notification'] . "</div>";
    unset($_SESSION['notification']);  // Clear the notification after displaying
}
?>
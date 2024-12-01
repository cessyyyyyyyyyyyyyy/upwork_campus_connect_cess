<?php
require_once '../includes/connection.php';
require_once '../includes/user_auth.php';

// Query to fetch projects for the logged-in user
$query = "
    SELECT 
        p.project_id, p.status, p.started_at, p.completed_at, p.cancelled_at, 
        s.title AS project_title, 
        CONCAT(u.first_name, ' ', u.last_name) AS freelancer_name, 
        p.payment_status, p.amount_paid,
        p.client_id, p.freelancer_id
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <title>My Active Jobs - Freelancer View</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/resets.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php include('includes/sidebar.php'); ?>

            <main class="col-md-9 col-lg-10">
                <section class="overview-page">
                    <h1>Active Jobs</h1>
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
                                        <th>Action</th>
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
                                                <a href="chat.php?client_id=<?php echo $row['client_id']; ?>" 
                                                    class="btn btn-primary">Message Client</a>
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
</body>
</html>

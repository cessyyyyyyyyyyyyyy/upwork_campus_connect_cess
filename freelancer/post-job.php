<?php
session_start();  // Ensure the session is started
require_once '../includes/connection.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobTitle = trim($_POST['jobTitle'] ?? '');
    $pricing = trim($_POST['pricing'] ?? '');
    $jobDescription = trim($_POST['jobDescription'] ?? '');

    if ($jobTitle && $pricing && $jobDescription) {
        $query = "INSERT INTO services (freelancer_id, title, description, price, created_at) VALUES (?, ?, ?, ?, NOW())";
        if ($stmt = $conn->prepare($query)) {
            $user_id = $_SESSION['user_id'];
            $stmt->bind_param('sssd', $user_id, $jobTitle, $jobDescription, $pricing);
            if ($stmt->execute()) {
                // Set a notification message
                $_SESSION['notifications'][] = "Your job has been posted successfully!";
            } else {
                // Set an error notification message
                $_SESSION['notifications'][] = "Error posting job. Please try again.";
            }
        } else {
            $_SESSION['notifications'][] = "Database error: " . htmlspecialchars($conn->error);
        }
    } else {
        $_SESSION['notifications'][] = "All fields are required.";
    }
}
?>

<?php if (isset($successMessage)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
<?php elseif (isset($errorMessage)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($errorMessage) ?></div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <title>Post a Job - Upwork Campus Connect</title>
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
            <!-- Main Content -->
            <main class="col-md-9 col-lg-10">
                <h1 class="my-4">Post a Job</h1>
                <p>Fill out the details to post your job listing</p>

                <form action="post-job.php" method="POST">
                    <div class="mb-3">
                        <label for="jobTitle" class="form-label">Job Title</label>
                        <input
                            type="text"
                            class="form-control"
                            id="jobTitle"
                            name="jobTitle"
                            placeholder="Enter the job title"
                            required
                        />
                    </div>

                    <div class="mb-3">
                        <label for="pricing" class="form-label">Pricing (₱)</label>
                        <input
                            type="number"
                            class="form-control"
                            id="pricing"
                            name="pricing"
                            required
                            placeholder="Enter your pricing in ₱"
                            min="1"
                        />
                    </div>

                    <div class="mb-3">
                        <label for="jobDescription" class="form-label">Job Description</label>
                        <textarea
                            class="form-control"
                            id="jobDescription"
                            name="jobDescription"
                            rows="4"
                            required
                            placeholder="Describe the job"
                        ></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Post Job</button>
                </form>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
require_once '../includes/connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

$project_id = $_GET['project_id'];
$user_id = $_SESSION['user_id'];  // Logged-in user ID

// Fetch project details
$query = "
    SELECT p.project_id, s.title AS project_title, p.freelancer_id, u.first_name, u.last_name
    FROM projects p
    JOIN services s ON p.job_id = s.service_id
    JOIN users u ON p.freelancer_id = u.user_id
    WHERE p.project_id = $project_id AND p.client_id = $user_id
";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    die("Project not found or access denied.");
}

$project = mysqli_fetch_assoc($result);

// Initialize error and success messages
$message = "";

// Handle review submission
if (isset($_POST['submit_review'])) {
    $rating = $_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $freelancer_id = $project['freelancer_id'];

    // Validate input
    if (empty($rating) || $rating < 1 || $rating > 5) {
        $message = "<div class='alert alert-danger'>Please select a valid rating (1 to 5).</div>";
    } elseif (empty($comment)) {
        $message = "<div class='alert alert-danger'>Comment cannot be empty.</div>";
    } else {
        // Proceed with insert if validation is successful
        $insert_query = "
            INSERT INTO freelancer_reviews (project_id, reviewer_id, freelancer_id, rating, comment)
            VALUES ($project_id, $user_id, $freelancer_id, $rating, '$comment')
        ";

        if (mysqli_query($conn, $insert_query)) {
            $message = "<div class='alert alert-success'>Review submitted successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon" />
    <title>Leave a Review</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/resets.css" />
    <link rel="stylesheet" href="../assets/css/sidebar.css" />
    <link rel="stylesheet" href="css/manage-projects.css" />
</head>
<body>
  <div class="container-fluid">
      <div class="row">
        <?php include('includes/sidebar.php'); ?>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10">
          <div class="container">
            <h1>Leave a Review for <?php echo htmlspecialchars($project['first_name'] . ' ' . $project['last_name']); ?></h1>
            
            <!-- Display validation or success message above the form -->
            <?php if ($message != "") { echo $message; } ?>

            <form method="POST">
              <div class="form-group">
                <label for="rating">Rating</label>
                <select name="rating" id="rating" class="form-select">
                  <option value="">Select Rating</option>
                  <option value="1">1 Star</option>
                  <option value="2">2 Stars</option>
                  <option value="3">3 Stars</option>
                  <option value="4">4 Stars</option>
                  <option value="5">5 Stars</option>
                </select>
              </div>
              <div class="form-group">
                <label for="comment">Comment</label>
                <textarea name="comment" id="comment" class="form-control" rows="5"></textarea>
              </div>
              <button type="submit" name="submit_review" class="btn btn-primary">Submit Review</button>
            </form>
          </div>
        </main>
      </div>
    </div>
</body>
</html>
 
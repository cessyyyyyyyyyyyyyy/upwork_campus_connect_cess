<?php
  require_once '../includes/connection.php';
  require_once '../includes/user_auth.php';
  // wag mo burahin, for debugging purposes
  // ini_set('display_errors', 1);
  // ini_set('display_startup_errors', 1);
  // error_reporting(E_ALL);
  
  // Fetch user details
  $user_id = $_SESSION['user_id'];
  $query = "SELECT first_name, last_name FROM users WHERE user_id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('i', $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();
      $user_name = $user['first_name'] . ' ' . $user['last_name'];
  } else {
      $user_name = "Unknown User";
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <title>Reviews - Upwork Campus Connect</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/resets.css" />
    <link rel="stylesheet" href="../assets/css/sidebar.css" />
    <link rel="stylesheet" href="css/reviews.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <?php include('includes/sidebar.php'); ?>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10">
          <!-- Submit Review Section -->
          <section class="overview-page">
            <h1>Submit Your Website Review</h1>

            <form action="../includes/submit_review.php" method="POST">
              <div class="form-group">
                <label for="reviewerName">Your Name:</label>
                <input
                  type="text"
                  name="reviewer_name"
                  class="form-control"
                  id="reviewerName"
                  value="<?php echo htmlspecialchars($user_name); ?>"
                  readonly
                  required
                />
              </div>

              <div class="form-group">
                <label for="reviewRating">Rating (1-5):</label>
                <select name="rating" class="form-control" id="reviewRating" required>
                  <option value="" disabled selected>Select a rating</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
              <div class="form-group">
                <label for="reviewText">Your Review:</label>
                <textarea name="comment" class="form-control" id="reviewText" rows="4" placeholder="Write your review here" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary btn-submit-review w-100">Submit Review</button>
            </form>
          </section>

          <section class="py-5 bg-white">
            <div class="container">
              <h2 class="text-center mb-4">Recent Reviews</h2>
              <div class="row row-cols-1 row-cols-md-3 g-4" id="reviewsContainer">
                <!-- Reviews will be populated dynamically here -->
              </div>
            </div>
          </section>
        </main>
      </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="../js/reviews.js"></script>
  </body>
</html>

<?php
  require_once '../includes/connection.php';

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="shortcut icon"
     
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
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <?php include('includes/sidebar.php'); ?>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10">
          <!-- Services Offered Section -->
          <?php include('includes/services.php'); ?>
        </main>
      </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

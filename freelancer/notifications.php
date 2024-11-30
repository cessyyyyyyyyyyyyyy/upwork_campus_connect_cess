<?php
session_start();  // Ensure the session is started
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
        rel="shortcut icon"
        href="../assets/logo-placeholder-white.svg"
        type="image/x-icon"
    />
    <title>Notifications - Upwork Campus Connect</title>
    <!-- Bootstrap CSS -->
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
            <!-- Sidebar (Desktop) -->
            <nav class="col-md-3 col-lg-2 sidebar bg-dark text-white d-none d-md-block">
            <a href="../index.php">
            <img
  src="../img/logo.png"
  alt="Logo"
  class="logo mb-4"
/>
</a>

                <ul>
                    <li><a href="get_overview_data.php">Overview</a></li>
                    <li><a href="notifications.php">Notifications</a></li>
                    <li><a href="active-jobs.php">Active Jobs</a></li>
                    <li><a href="post-job.php">Post a Job</a></li>
                    <li><a href="earnings.php">Earnings</a></li>
                    <li><a href="messaging_freelancer.php">Message</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10">
                <section class="notifications-page">
                    <h1>Notifications</h1>
                    <div class="notifications-list">
                        <?php
                        // Display notifications if available
                        if (isset($_SESSION['notifications']) && count($_SESSION['notifications']) > 0) {
                            foreach ($_SESSION['notifications'] as $notification) {
                                echo "<div class='notification-item'><p><strong>" . htmlspecialchars($notification) . "</strong></p></div>";
                            }
                            // Clear notifications after displaying
                            unset($_SESSION['notifications']);
                        } else {
                            echo "<div class='notification-item'><p>No new notifications.</p></div>";
                        }
                        ?>
                    </div>
                </section>

            

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>

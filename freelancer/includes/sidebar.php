<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar (Desktop) -->
<nav class="col-md-3 col-lg-2 sidebar bg-dark text-white d-none d-md-block">
  <img src="../assets/logo.png" alt="Logo icon" class="logo" style="backdrop-filter: invert(1); border-radius: 50%">
  <ul class="mt-4">
    <li><a href="get_overview_data.php" class="<?php echo ($current_page == 'get_overview_data.php') ? 'active' : ''; ?>">Overview</a></li>
    <li><a href="notifications.php" class="<?php echo ($current_page == 'notifications.php') ? 'active' : ''; ?>">Notifications</a></li>
    <li><a href="active-jobs.php" class="<?php echo ($current_page == 'active-jobs.php') ? 'active' : ''; ?>">Active Jobs</a></li>
    <li><a href="post-job.php" class="<?php echo ($current_page == 'post-job.php') ? 'active' : ''; ?>">Post a Job</a></li>
    <li><a href="earnings.php" class="<?php echo ($current_page == 'earnings.php') ? 'active' : ''; ?>">Earnings</a></li>
    <li><a href="chat.php" class="<?php echo ($current_page == 'chat.php') ? 'active' : ''; ?>">Messages</a></li>
    <li><a href="../logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">Logout</a></li>
  </ul>
</nav>

<!-- Mobile Navbar (Visible on mobile) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-md-none">
  <button
    class="navbar-toggler"
    type="button"
    data-bs-toggle="collapse"
    data-bs-target="#navbarNav"
    aria-controls="navbarNav"
    aria-expanded="false"
    aria-label="Toggle navigation"
  >
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'get_overview_data.php') ? 'active' : ''; ?>" href="get_overview_data.php">Overview</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'notifications.php') ? 'active' : ''; ?>" href="notifications.php">Notifications</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'active-jobs.php') ? 'active' : ''; ?>" href="active-jobs.php">Active Jobs</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'post-job.php') ? 'active' : ''; ?>" href="post-job.php">Post a Job</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'earnings.php') ? 'active' : ''; ?>" href="earnings.php">Earnings</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'chat.php') ? 'active' : ''; ?>" href="chat.php">Messages</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Sidebar (Desktop) -->
<nav class="col-md-3 col-lg-2 sidebar bg-light text-black d-none d-md-block" style="background-color: #f5f5f5 !important">
  <img src="../assets/logo.png" alt="Logo icon" class="logo">
 
  <ul class="mt-4">
    <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Overview</a></li>
    <li><a href="manage-projects.php" class="<?php echo ($current_page == 'manage-projects.php') ? 'active' : ''; ?>">Manage Projects</a></li>
    <li><a href="services.php" class="<?php echo ($current_page == 'services.php') ? 'active' : ''; ?>">Services</a></li>
    <li><a href="payments.php" class="<?php echo ($current_page == 'payments.php') ? 'active' : ''; ?>">Payments</a></li>
    <li><a href="reviews.php" class="<?php echo ($current_page == 'reviews.php') ? 'active' : ''; ?>">Reviews</a></li>
    <li><a href="chat.php" class="<?php echo ($current_page == 'chat.php') ? 'active' : ''; ?>">Messages</a></li>
    <li><a href="../logout.php">Logout</a></li>
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
        <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Overview</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'manage-projects.php') ? 'active' : ''; ?>" href="manage-projects.php">Manage Projects</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'services.php') ? 'active' : ''; ?>" href="services.php">Services</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'payments.php') ? 'active' : ''; ?>" href="payments.php">Payments</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo ($current_page == 'reviews.php') ? 'active' : ''; ?>" href="reviews.php">Reviews</a>
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

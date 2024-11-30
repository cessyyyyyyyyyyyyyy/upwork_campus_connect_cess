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
    <title>Settings - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../assets/css/sidebar.css" />
    <link rel="stylesheet" href="../assets/css/resets.css" />
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar (Desktop) -->
        <nav
          class="col-md-3 col-lg-2 sidebar bg-dark text-white d-none d-md-block"
        >
        <img
  src="../img/logo.png"
  alt="Logo"
  class="logo mb-4"
/>
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="manage-users.html">Manage Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="manage-freelancers.html"
                >Manage Freelancers</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="manage-jobs.php">Manage Jobs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="settings.php">Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Logout</a>
            </li>
          </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 main-content">
          <div class="container mt-5">
            <h2>Settings</h2>
            <form>
              <div class="mb-3">
                <label for="adminEmail" class="form-label">Admin Email</label>
                <input
                  type="email"
                  class="form-control"
                  id="adminEmail"
                  placeholder="Enter admin email"
                />
              </div>
              <div class="mb-3">
                <label for="adminPassword" class="form-label">Password</label>
                <input
                  type="password"
                  class="form-control"
                  id="adminPassword"
                  placeholder="Enter new password"
                />
              </div>
              <div class="mb-3">
                <label for="siteName" class="form-label">Site Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="siteName"
                  placeholder="Enter site name"
                />
              </div>
              <div class="mb-3">
                <label for="siteLogo" class="form-label">Site Logo</label>
                <input type="file" class="form-control" id="siteLogo" />
              </div>
              <div class="mb-3">
                <label for="siteTheme" class="form-label">Theme</label>
                <select class="form-select" id="siteTheme">
                  <option value="light">Light</option>
                  <option value="dark">Dark</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">
                Save Settings
              </button>
            </form>
          </div>
        </main>
      </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

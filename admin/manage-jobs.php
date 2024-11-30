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
    <title>Manage Jobs - Admin Dashboard</title>
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
              <a class="nav-link" href="manage-users.php">Manage Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="manage-freelancers.php"
                >Manage Freelancers</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="manage-jobs.php">Manage Jobs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="settings.php">Settings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="login.php">Logout</a>
            </li>
          </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-9 col-lg-10 main-content">
          <div class="container mt-5">
            <h2>Manage Jobs</h2>
            <div class="row mb-4">
              <div class="col-md-4">
                <button
                  class="btn btn-primary w-100"
                  data-bs-toggle="modal"
                  data-bs-target="#postJobModal"
                  id="postJobBtn"
                >
                  Post a New Job
                </button>
              </div>
              <div class="col-md-8">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    id="searchInput"
                    placeholder="Search Jobs"
                  />
                  <button class="btn btn-outline-secondary" type="button" id="searchButton">
                    Search
                  </button>
                </div>
              </div>
            </div>

            <!-- Jobs Table -->
            <table class="table table-striped" id="jobsTable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Job Title</th>
                  <th scope="col">Category</th>
                  <th scope="col">Budget</th>
                  <th scope="col">Status</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody id="jobTableBody">
                <!-- Job row example 1 -->
                <tr>
                  <th scope="row">1</th>
                  <td>Web Development</td>
                  <td>Frontend</td>
                  <td>₱6000</td>
                  <td>Pending</td>
                  <td>
                    <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#postJobModal">Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                  </td>
                </tr>
                <!-- Job row example 2 -->
                <tr>
                  <th scope="row">2</th>
                  <td>Graphic Design</td>
                  <td>Design</td>
                  <td>₱300</td>
                  <td>Active</td>
                  <td>
                    <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#postJobModal">Edit</button>
                    <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>

            <!-- Post Job Modal -->
            <div
              class="modal fade"
              id="postJobModal"
              tabindex="-1"
              aria-labelledby="postJobModalLabel"
              aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="postJobModalLabel">Post a New Job</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form id="postJobForm">
                      <div class="mb-3">
                        <label for="jobTitle" class="form-label">Job Title</label>
                        <input
                          type="text"
                          class="form-control"
                          id="jobTitle"
                          placeholder="Enter job title"
                        />
                      </div>
                      <div class="mb-3">
                        <label for="jobCategory" class="form-label">Category</label>
                        <select class="form-select" id="jobCategory">
                          <option value="web-design">Web Design</option>
                          <option value="frontend-dev">Frontend Development</option>
                          <option value="graphic-design">Graphic Design</option>
                        </select>
                      </div>
                      <div class="mb-3">
                        <label for="jobBudget" class="form-label">Budget (₱)</label>
                        <input
                          type="number"
                          class="form-control"
                          id="jobBudget"
                          placeholder="Enter budget"
                        />
                      </div>
                      <div class="mb-3">
                        <label for="jobStatus" class="form-label">Status</label>
                        <select class="form-select" id="jobStatus">
                          <option value="active">Active</option>
                          <option value="inactive">Inactive</option>
                          <option value="completed">Completed</option>
                          <option value="pending">Pending</option>
                        </select>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-secondary"
                      data-bs-dismiss="modal"
                    >
                      Close
                    </button>
                    <button type="button" class="btn btn-primary" id="createJobBtn">Post Job</button>
                    <button type="button" class="btn btn-primary" id="updateJobBtn" style="display:none;">Update Job</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </main>
      </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>

    <script>
      let editRow = null; // To store the row that is being edited

      // Show "Post Job" button and hide "Update Job" button when creating a new job
      document.getElementById('postJobBtn').addEventListener('click', function() {
        // Reset the form and show "Post Job" button
        document.getElementById('postJobForm').reset();
        document.getElementById('createJobBtn').style.display = 'block';
        document.getElementById('updateJobBtn').style.display = 'none';
      });

      // Function to add a new job to the table
      document.getElementById('createJobBtn').addEventListener('click', function() {
        const title = document.getElementById('jobTitle').value;
        const category = document.getElementById('jobCategory').value;
        const budget = document.getElementById('jobBudget').value;
        const status = document.getElementById('jobStatus').value;

        if (title && category && budget && status) {
          const tableBody = document.getElementById('jobTableBody');
          const row = tableBody.insertRow();

          const cell1 = row.insertCell(0);
          const cell2 = row.insertCell(1);
          const cell3 = row.insertCell(2);
          const cell4 = row.insertCell(3);
          const cell5 = row.insertCell(4);
          const cell6 = row.insertCell(5);

          cell1.textContent = tableBody.rows.length;
          cell2.textContent = title;
          cell3.textContent = category;
          cell4.textContent = `₱${budget}`;
          cell5.textContent = status;
          cell6.innerHTML = `
            <button class="btn btn-warning btn-sm edit-btn" data-bs-toggle="modal" data-bs-target="#postJobModal">Edit</button>
            <button class="btn btn-danger btn-sm delete-btn">Delete</button>
          `;

          // Close modal and reset form
          const modal = bootstrap.Modal.getInstance(document.getElementById('postJobModal'));
          modal.hide();
          document.getElementById('postJobForm').reset();
        }
      });

      // Edit job functionality
      document.getElementById('jobTableBody').addEventListener('click', function(e) {
        if (e.target.classList.contains('edit-btn')) {
          const row = e.target.closest('tr');
          const cells = row.getElementsByTagName('td');

          // Populate form fields with the current job data
          document.getElementById('jobTitle').value = cells[0].textContent; // Title
          document.getElementById('jobCategory').value = cells[1].textContent; // Category
          document.getElementById('jobBudget').value = cells[2].textContent.slice(1); // Remove ₱ symbol
          document.getElementById('jobStatus').value = cells[3].textContent.toLowerCase(); // Status

          // Show the "Update Job" button and hide the "Post Job" button
          document.getElementById('createJobBtn').style.display = 'none';
          document.getElementById('updateJobBtn').style.display = 'block';

          // Store the row for updating later
          editRow = row;
        }
      });

      // Update job functionality
      document.getElementById('updateJobBtn').addEventListener('click', function() {
        const title = document.getElementById('jobTitle').value;
        const category = document.getElementById('jobCategory').value;
        const budget = document.getElementById('jobBudget').value;
        const status = document.getElementById('jobStatus').value;

        if (title && category && budget && status && editRow) {
          const cells = editRow.getElementsByTagName('td');

          // Update the table cells with new values
          cells[0].textContent = title;  // Title
          cells[1].textContent = category;  // Category
          cells[2].textContent = `₱${budget}`;  // Budget
          cells[3].textContent = status;  // Status

          // Hide the "Update Job" button and show the "Post Job" button
          document.getElementById('createJobBtn').style.display = 'block';
          document.getElementById('updateJobBtn').style.display = 'none';

          // Close modal and reset form
          const modal = bootstrap.Modal.getInstance(document.getElementById('postJobModal'));
          modal.hide();
          document.getElementById('postJobForm').reset();
        }
      });
    </script>
  </body>
</html>

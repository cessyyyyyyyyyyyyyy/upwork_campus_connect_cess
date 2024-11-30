<?php
require_once 'includes/connection.php';
// For debugging purposes, enable error display if needed
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Query to fetch the 3 most recent reviews
$query_reviews = "SELECT reviewer_name, rating, comment FROM overall_reviews ORDER BY created_at DESC LIMIT 3"; 
$result_reviews = $conn->query($query_reviews);

$reviews = [];
if ($result_reviews->num_rows > 0) {
    while ($row = $result_reviews->fetch_assoc()) {
        $reviews[] = $row;
    }
}

// Query to fetch the 3 most recent services
$query_services = "SELECT s.title, s.description, s.price, u.first_name, u.last_name, s.created_at 
                   FROM services s
                   JOIN users u ON s.freelancer_id = u.user_id
                   WHERE u.user_type = 'freelancer'
                   ORDER BY s.created_at DESC LIMIT 3";
$result_services = $conn->query($query_services);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon" />
    <title>Upwork Campus Connect</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/index.css" />
    <link rel="stylesheet" href="assets/css/footer.css">
  </head>
  <body>
    <main>
      <!-- Navigation Bar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light py-3 shadow-sm">
        <div class="container">
          <a class="navbar-brand" href="index.php">
            <img src="img/logo.png" alt="logo" width="100" height="100" />
            <span class="ms-2">Campus Connect</span>
          </a>

          <!-- Visible Search Bar -->
          <form id="searchForm" class="d-flex ms-auto me-3">
            <input class="form-control search-bar me-2" type="search" placeholder="Search job" aria-label="Search" name="query" id="searchQuery" />
            <button class="btn btn-outline-primary" type="submit">Search</button>
          </form>

          <div>
            <a href="signup.php" class="btn btn-primary me-2">Signup</a>
            <a href="login.php" class="btn btn-outline-secondary">Login</a>
          </div>
        </div>
      </nav>

      <!-- Header Section -->
      <header class="text-center bg-light py-5 header-section">
        <div class="container">
          <h1 class="display-4 fw-bold">Welcome to Campus Connect</h1>
          <p class="lead">Your one-stop platform for connecting clients with talented freelancers.</p>
          <ul class="list-inline mt-4">
            <li class="list-inline-item"><a href="#" class="btn btn-outline-secondary">Graphic Design</a></li>
            <li class="list-inline-item"><a href="#" class="btn btn-outline-secondary">Writing</a></li>
            <li class="list-inline-item"><a href="#" class="btn btn-outline-secondary">Development</a></li>
          </ul>
        </div>
      </header>

      <!-- Testimonials Section -->
      <section class="py-5 bg-white">
        <div class="container">
          <h2 class="text-center mb-4">Recent Reviews</h2>
          <div class="row row-cols-1 row-cols-md-3 g-4" id="reviewsContainer">
            <?php
            // Loop through the reviews and display them
            if (!empty($reviews)) {
                foreach ($reviews as $review) {
                    echo '<div class="col">
                            <div class="card border-0 shadow-sm h-100">
                              <div class="card-body text-center">
                                <p class="card-title fw-bold">' . htmlspecialchars($review['reviewer_name']) . '</p>
                                <div class="mb-2">' . str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']) . '</div>
                                <p class="card-text">"' . htmlspecialchars($review['comment']) . '"</p>
                              </div>
                            </div>
                          </div>';
                }
            } else {
                echo '<p>No reviews yet.</p>';
            }
            ?>
          </div>
        </div>
      </section>

      <!-- Services Offered Section -->
      <section class="py-5">
        <div class="container">
          <h3 class="text-center mb-4">Services Offered</h3>
          <div class="row row-cols-1 row-cols-md-3 g-4" id="servicesContainer">
            <?php
            // Loop through the services and display them
            if ($result_services->num_rows > 0) {
                while ($service = $result_services->fetch_assoc()) {
                    echo '<div class="col">
                            <div class="card border-0 shadow-sm h-100">
                              <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($service['title']) . '</h5>
                                <ul class="list-unstyled">
                                  <li><strong>Freelancer:</strong> ' . htmlspecialchars($service['first_name']) . ' ' . htmlspecialchars($service['last_name']) . '</li>
                                  <li><strong>Price:</strong> ₱' . number_format($service['price'], 2) . '</li>
                                  <li><strong>Description:</strong> ' . htmlspecialchars($service['description']) . '</li>
                                </ul>
                                <button class="btn btn-primary w-100">Apply</button>
                              </div>
                            </div>
                          </div>';
                }
            } else {
                echo '<p>No services available at the moment.</p>';
            }
            ?>
          </div>
        </div>
      </section>

    </main>

    <!-- FontAwesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />


      <!-- Footer -->
<footer class="bg-dark text-white py-4">
  <div class="container">
    <div class="row align-items-center">
      <!-- Left Section: Partnered with TCU -->
      <div class="col-md-4 text-center text-md-left">
        <img src="img/tcu_logo.png" alt="Taguig City University" width="50" class="tcu-logo">
        <p>Partnered with</p>
        <p><strong>Taguig City University</strong></p>
      </div>

      <!-- Center Section: Upwork Campus Connect Logo and Name -->
      <div class="col-md-4 text-center">
        <a href="index.html">
        <img src="img/logo.png" alt="logo" width="90" height="90" />
        </a>
        <p class="mt-2">Campus Connect</p>
      </div>

      <!-- Right Section: Contact Us (Social Icons) -->
      <div class="col-md-4 text-center text-md-right">
        <div class="contact-section">
          <a href="https://www.facebook.com" target="_blank" class="text-white me-3">
            <i class="fab fa-facebook fa-2x"></i>
          </a>
          <a href="mailto:example@gmail.com" class="text-white me-3">
            <i class="fas fa-envelope fa-2x"></i>
          </a>
          <a href="tel:+1234567890" class="text-white">
            <i class="fas fa-phone fa-2x"></i>
          </a>
          
        </div>
        <p class="mt-2">Contact Us</p> <!-- Added Contact Us text -->
      </div>
    </div>
  </div>
</footer>

    
      
    



    <!-- Modal for Search Results -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="searchModalLabel">Search Results</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" id="searchResults">
            <!-- Dynamic search results will appear here -->
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (Needed for AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
      $(document).ready(function () {
        $('#searchForm').on('submit', function (e) {
          e.preventDefault(); // Prevent form submission
          
          let query = $('#searchQuery').val(); // Get the search query
          if (query.trim() === '') {
            alert('Please enter a search term.');
            return;
          }

          // Display loading message
          $('#searchResults').html('<p class="text-center text-muted">Loading...</p>');

          // AJAX request to fetch search results
          $.ajax({
            url: 'search_endpoint.php', // Your search endpoint
            method: 'GET',
            data: { query: query },
            success: function (data) {
              try {
                let results = JSON.parse(data); // Parse JSON data from the server
                $('#searchResults').empty(); // Clear previous results

                if (results.length > 0) {
                  results.forEach(function (item) {
                    $('#searchResults').append(`
                      <div class="result-item">
                        <h5>${item.title}</h5>
                        <p>${item.description}</p>
                        <button class="btn btn-primary">Apply</button>
                      </div>
                    `);
                  });
                } else {
                  $('#searchResults').html('<p>No results found.</p>');
                }
                // Show modal
                $('#searchModal').modal('show');
              } catch (error) {
                $('#searchResults').html('<p class="text-danger">Error loading results. Please try again later.</p>');
              }
            },
            error: function () {
              $('#searchResults').html('<p class="text-danger">Error fetching data. Please try again later.</p>');
            }
          });
        });
      });
    </script>
  </body>
</html>

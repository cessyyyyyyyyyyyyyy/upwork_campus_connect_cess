<?php
require_once 'includes/connection.php';

// Get the search query from the URL
$query = isset($_GET['query']) ? $_GET['query'] : '';

// If a query is provided, search the database for relevant services
$search_results = [];
if (!empty($query)) {
    $query_services = "SELECT s.title, s.description, s.price, u.first_name, u.last_name 
                       FROM services s
                       JOIN users u ON s.freelancer_id = u.user_id
                       WHERE u.user_type = 'freelancer' AND (s.title LIKE ? OR s.description LIKE ?)";
    
    $stmt = $conn->prepare($query_services);
    $search_query = "%$query%";
    $stmt->bind_param('ss', $search_query, $search_query);
    $stmt->execute();
    $result_services = $stmt->get_result();

    if ($result_services->num_rows > 0) {
        while ($service = $result_services->fetch_assoc()) {
            $search_results[] = $service;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/logo-placeholder-white.svg" type="image/x-icon" />
    <title>Search Results</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet" />
  </head>
  <body>
    <div class="container py-5">
      <h2 class="text-center mb-4">Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
      
      <?php if (count($search_results) > 0): ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <?php foreach ($search_results as $service): ?>
            <div class="col">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title"><?php echo htmlspecialchars($service['title']); ?></h5>
                  <ul class="list-unstyled">
                    <li><strong>Freelancer:</strong> <?php echo htmlspecialchars($service['first_name']) . ' ' . htmlspecialchars($service['last_name']); ?></li>
                    <li><strong>Price:</strong> ₱<?php echo number_format($service['price'], 2); ?></li>
                    <li><strong>Description:</strong> <?php echo htmlspecialchars($service['description']); ?></li>
                  </ul>
                  <button class="btn btn-primary w-100">Apply</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-center">No services found for your search query.</p>
      <?php endif; ?>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

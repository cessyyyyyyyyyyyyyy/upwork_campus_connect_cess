<?php
// search_endpoint.php

// Assuming you are using PDO for database connection
$pdo = new PDO("mysql:host=localhost;dbname=upwork_campus_connect_db", "username", "password");

// Get the search query from the URL parameter
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Prepare the SQL query to search for jobs or services
$stmt = $pdo->prepare("SELECT title, description FROM services WHERE title LIKE :query OR description LIKE :query");
$stmt->execute(['query' => '%' . $query . '%']);

// Fetch the results
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the results as JSON
echo json_encode($results);
?>

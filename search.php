<?php
require_once 'includes/connection.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
$searchQuery = mysqli_real_escape_string($conn, $query);

$sql = "SELECT s.title, s.description, s.price, u.first_name, u.last_name
        FROM services s
        JOIN users u ON s.freelancer_id = u.user_id
        WHERE s.title LIKE '%$searchQuery%' OR s.description LIKE '%$searchQuery%'";

$result = $conn->query($sql);

$searchResults = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $searchResults[] = $row;
    }
}

echo json_encode($searchResults);
?>

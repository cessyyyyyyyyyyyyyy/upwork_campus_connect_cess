<?php
require_once 'connection.php';

// Fetch recent reviews from `overall_reviews` table
$stmt = $conn->prepare("SELECT reviewer_name, rating, comment, created_at FROM overall_reviews ORDER BY created_at DESC LIMIT 3");
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    $reviews[] = $row;
}

echo json_encode($reviews);

$stmt->close();

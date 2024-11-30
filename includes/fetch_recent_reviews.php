<?php
require_once 'connection.php';

$stmt = $conn->prepare("
    SELECT reviews.rating, reviews.comment, users.first_name, users.last_name, reviews.created_at 
    FROM reviews 
    JOIN users ON reviews.reviewer_id = users.user_id 
    ORDER BY reviews.created_at DESC 
    LIMIT 3
");
$stmt->execute();
$result = $stmt->get_result();

$recentReviews = [];
while ($row = $result->fetch_assoc()) {
    $recentReviews[] = $row;
}

echo json_encode($recentReviews);

$stmt->close();
?>

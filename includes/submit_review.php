<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewer_name = $_POST['reviewer_name'];
    $rating = intval($_POST['rating']);
    $comment = $_POST['comment'];

    // Validate rating range
    if ($rating < 1 || $rating > 5) {
        http_response_code(400);
        echo json_encode(['message' => 'Rating must be between 1 and 5.']);
        exit();
    }

    // Insert review into `overall_reviews` table
    $stmt = $conn->prepare("INSERT INTO overall_reviews (reviewer_name, rating, comment) VALUES (?, ?, ?)");
    $stmt->bind_param('sis', $reviewer_name, $rating, $comment);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Review submitted successfully.']);
    } else {
        echo json_encode(['message' => 'Error submitting review.']);
    }

    $stmt->close();
}
?>

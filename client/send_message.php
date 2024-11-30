<?php
// Save the message sent by the client or freelancer to the database
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$message = $_POST['message'];

// Assuming you have a database connection setup
$stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message, timestamp) VALUES (:sender_id, :receiver_id, :message, NOW())");
$stmt->execute(['sender_id' => $sender_id, 'receiver_id' => $receiver_id, 'message' => $message]);

echo "Message sent successfully";

// send_message.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Insert the message into the database
    $sql = "INSERT INTO messages (sender_id, receiver_id, message, created_at, read_status) 
            VALUES ('$sender_id', '$receiver_id', '$message', NOW(), 'unread')";
    $conn->query($sql);
}

?>

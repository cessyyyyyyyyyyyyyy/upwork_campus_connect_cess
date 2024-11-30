<?php
session_start();

// Ensure user is logged in and session variables are set
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}

// Get logged-in user ID from session
$loggedInUserId = $_SESSION['user_id']; 

// Fetch user role (user_type) from the database if not in session
require_once '../includes/connection.php';

// Fetch the user role from the database for the logged-in user
$sql = "SELECT user_type FROM users WHERE user_id = '$loggedInUserId'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userRole = $row['user_type']; // 'client' or 'freelancer'
} else {
    echo "Error: User not found.";
    exit;
}

// Get the sender and receiver IDs from the GET parameters
$sender_id = isset($_GET['sender_id']) ? $_GET['sender_id'] : null;
$receiver_id = isset($_GET['receiver_id']) ? $_GET['receiver_id'] : null;

if (!$sender_id || !$receiver_id) {
    echo "Invalid request.";
    exit;
}

// Query to fetch messages between sender and receiver
$sql = "
    SELECT m.message_id, m.message, m.created_at, 
           u.first_name, u.last_name, u.user_type
    FROM messages m
    JOIN users u ON m.sender_id = u.user_id
    WHERE (m.sender_id = '$loggedInUserId' OR m.receiver_id = '$loggedInUserId')
    AND (m.sender_id = '$sender_id' OR m.receiver_id = '$receiver_id')
    ORDER BY m.created_at DESC
";

$result = $conn->query($sql);
?>

<div class="message-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sender_name = $row['first_name'] . ' ' . $row['last_name'];
            $user_type = $row['user_type'];

            $message_class = ($user_type == 'client') ? 'client-message' : 'freelancer-message';

            echo "<div class='message $message_class'>";
            echo "<p><strong>$sender_name</strong> ($user_type): " . $row['message'] . "</p>";
            echo "<p><small>Sent at: " . $row['created_at'] . "</small></p>";
            echo "</div>";
        }
    } else {
        echo "No messages found.";
    }

    // Query to fetch messages between sender and receiver, including read status
$sql = "
SELECT m.message_id, m.message, m.created_at, m.read_status,
       u.first_name, u.last_name, u.user_type
FROM messages m
JOIN users u ON m.sender_id = u.user_id
WHERE (m.sender_id = '$loggedInUserId' OR m.receiver_id = '$loggedInUserId')
AND (m.sender_id = '$sender_id' OR m.receiver_id = '$receiver_id')
ORDER BY m.created_at DESC
";
// Mark the messages as read for the logged-in user
$sql_update = "
    UPDATE messages
    SET read_status = 'read'
    WHERE (sender_id = '$sender_id' OR receiver_id = '$sender_id')
    AND (sender_id = '$loggedInUserId' OR receiver_id = '$loggedInUserId')
    AND read_status = 'unread'
";
$conn->query($sql_update);

    ?>
</div>

<?php
$conn->close();
?>

<?php
require_once '../includes/connection.php';
require_once '../includes/user_auth.php';
// For debugging purposes
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Fetch sender (logged-in user) and receiver (selected client) IDs
$sender_id = $user_id; // Assuming $user_id is defined in your user_auth.php or session
$receiver_id = $_GET['client_id'] ?? null; // Get the client_id from the URL parameter

// Fetch all clients that the freelancer has active conversations with
$query = "
    SELECT DISTINCT
        IF(m.sender_id = $user_id, m.receiver_id, m.sender_id) AS other_party_id
    FROM messages m
    WHERE m.sender_id = $user_id OR m.receiver_id = $user_id
    ORDER BY m.timestamp DESC
";

$result = mysqli_query($conn, $query);

// Fetch each client's name
$clients = [];
while ($row = mysqli_fetch_assoc($result)) {
    $other_party_id = $row['other_party_id'];
    $client_query = "SELECT first_name, last_name FROM users WHERE user_id = $other_party_id";
    $client_result = mysqli_query($conn, $client_query);
    $client_data = mysqli_fetch_assoc($client_result);

    $clients[] = [
        'id' => $other_party_id,
        'name' => $client_data['first_name'] . ' ' . $client_data['last_name']
    ];
}

// If no client is selected, display the list of clients
if (!isset($_GET['client_id'])) {
    echo '<!DOCTYPE html>';
    echo '<html lang="en">';
    echo '<head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">';
    echo '<title>Active Conversations</title>';
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css">';
    echo '<link rel="stylesheet" href="css/sidebar.css">';
    echo '<link rel="stylesheet" href="../assets/css/resets.css">';
    echo '</head>';
    echo '<body>';
    echo '<div class="container-fluid">';
    echo '<div class="row">';
    // Include Sidebar
    include('includes/sidebar.php');
    
    // Active Conversations List
    echo '<div class="col-12 col-md-9 mt-4 mt-md-5">';
    echo '<h1>Active Conversations</h1>';
    echo '<ul class="list-group">';
    foreach ($clients as $client) {
        echo '<li class="list-group-item">';
        echo '<a href="chat.php?client_id=' . $client['id'] . '" class="text-decoration-none">' . htmlspecialchars($client['name']) . '</a>';
        echo '</li>';
    }
    echo '</ul>';
    echo '</div>';  // End col-12 col-md-9
    echo '</div>';  // End row
    echo '</div>';  // End container-fluid
    echo '</body>';
    echo '</html>';
    exit();
}

// Fetch the selected client's details
$selected_client_query = "SELECT first_name, last_name FROM users WHERE user_id = $receiver_id";
$selected_client_result = mysqli_query($conn, $selected_client_query);
$selected_client = mysqli_fetch_assoc($selected_client_result);

// Fetch the selected client's messages
$messages_query = "
    SELECT * 
    FROM messages
    WHERE (sender_id = $sender_id AND receiver_id = $receiver_id) 
       OR (sender_id = $receiver_id AND receiver_id = $sender_id)
    ORDER BY timestamp ASC
";
$messages_result = mysqli_query($conn, $messages_query);


// Handle new message submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    if (!empty($content)) {
        // Insert the message into the database
        $insert_query = "
            INSERT INTO messages (sender_id, receiver_id, content, timestamp, is_read)
            VALUES ($sender_id, $receiver_id, '$content', NOW(), 0)
        ";
        if (mysqli_query($conn, $insert_query)) {
            // Reload the page to display the new message
            header("Location: chat.php?client_id=$receiver_id");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error sending message: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/logo.png" type="image/x-icon">
    <title>Chat - <?php echo htmlspecialchars($selected_client['first_name'] . ' ' . $selected_client['last_name']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/resets.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
        <?php include('includes/sidebar.php'); ?>

      <!-- Chat Box -->
      <div class="col-12 col-md-9 mt-4 mt-md-5">
        <h1><?php echo htmlspecialchars($selected_client['first_name'] . ' ' . $selected_client['last_name']); ?></h1>

        <!-- Message display area -->
        <div class="chat-box border rounded p-3 mb-4" style="height: 700px; overflow-y: scroll;">
            <?php while ($message = mysqli_fetch_assoc($messages_result)): ?>
                <div class="<?php echo $message['sender_id'] == $user_id ? 'text-end' : 'text-start'; ?> mb-3">
                    <p class="d-inline-block px-3 py-2 rounded bg-<?php echo $message['sender_id'] == $user_id ? 'primary text-white' : 'secondary text-white'; ?>">
                        <?php echo htmlspecialchars($message['content']); ?>
                    </p>
                    <br>
                    <small class="text-muted"><?php echo date('M d, Y h:i A', strtotime($message['timestamp'])); ?></small>
                </div>
            <?php endwhile; ?>
        </div>


        <!-- Message input form -->
        <form method="POST" class="mt-4">
          <div class="input-group">
            <input type="text" name="content" class="form-control" placeholder="Type your message..." required>
            <button class="btn btn-primary" type="submit">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Scroll to the bottom of the chat box when new messages are loaded or sent
    window.onload = function() {
        var chatBox = document.querySelector('.chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    };

    // If you want to trigger this when new messages are sent via the form:
    document.querySelector('form').addEventListener('submit', function() {
        var chatBox = document.querySelector('.chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    });
  </script>
</body>
</html>

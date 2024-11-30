


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Freelancer Message</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/sidebar.css" />
    <link rel="stylesheet" href="../assets/css/resets.css" />
    <style>
        #chat-container {
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #chat-box {
            height: 400px;
            overflow-y: auto;
            padding: 15px;
            background-color: #f8f9fa;
        }

        .message {
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 10px;
        }

        .message p {
            margin: 0;
        }

        .message strong {
            color: #333;
        }

        .message small {
            color: #777;
        }

        .message-container {
    display: flex;
    flex-direction: column-reverse; /* Reverses the order of messages */
    overflow-y: auto;
    height: 400px; /* Adjust as needed */
}

.message {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.client-message {
    background-color: #e6f7ff; /* Light blue for clients */
}

.freelancer-message {
    background-color: #f2f2f2; /* Light gray for freelancers */
}


        .message .bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 15px;
            font-size: 14px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .message.sent .bubble {
            background-color: #25d366;
            color: white;
            border-bottom-right-radius: 0;
        }

        .message.received .bubble {
            background-color: #dcf8c6;
            color: black;
            border-bottom-left-radius: 0;
        }

        .message small {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }

        #message-form {
            display: flex;
            gap: 10px;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: white;
        }

        #message-form input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }

        #message-form button {
            background-color: #25d366;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 10px 15px;
            cursor: pointer;
        }

        #message-form button:hover {
            background-color: #128c7e;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (Desktop) -->
            <nav class="col-md-3 col-lg-2 sidebar bg-dark text-white d-none d-md-block">
            <img
  src="../img/logo.png"
  alt="Logo"
  class="logo mb-4"
/>
                <ul>
                    <li><a href="get_overview_data.php">Overview</a></li>
                    <li><a href="notifications.php">Notifications</a></li>
                    <li><a href="active-jobs.php">Active Jobs</a></li>
                    <li><a href="post-job.php">Post a Job</a></li>
                    <li><a href="earnings.php">Earnings</a></li>
                    <li><a href="messaging_freelancer.php">Message</a></li>
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </nav>

            <div id="chat-container">
                <div id="chat-box">
                    <div class="placeholder">Loading messages...</div>
                </div>

                <form id="message-form">
                    <input type="hidden" id="sender_id" value="1" />
                    <input type="hidden" id="receiver_id" value="2" />
                    <input type="text" id="message-input" placeholder="Type your message..." required />
                    <button type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                            <path d="M15.964 0.686a.5.5 0 0 1-.104.547L1.684 14.328a.5.5 0 0 1-.868-.322L.3 9.354a1.5.5 0 0 1 0-2.708L.816 1.21A.5.5 0 0 1 1.23.707l14.63-2.447a.5.5 0 0 1 .548.426z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
       const chatBox = document.getElementById("chat-box");
const messageForm = document.getElementById("message-form");
const messageInput = document.querySelector("#message-form input[type='text']");
const senderId = document.querySelector("#sender_id").value;  // From hidden input
const receiverId = document.querySelector("#receiver_id").value;  // From hidden input

// Function to fetch messages
async function fetchMessages() {
    try {
        const response = await fetch(`fetch_messages.php?sender_id=${senderId}&receiver_id=${receiverId}`);
        if (!response.ok) throw new Error("Failed to fetch messages");
        const messages = await response.text();

        // Update chatBox only if new content is fetched
        if (chatBox.innerHTML !== messages) {
            chatBox.innerHTML = messages;
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    } catch (error) {
        console.error("Error fetching messages:", error);
    }
}

// Handle message submission
messageForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const message = messageInput.value.trim();
    if (message) {
        chatBox.innerHTML += `
            <div class="message sent">
                <div class="bubble">${message}</div>
                <small>You (Just Now)</small>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;

        await fetch("send_message.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams({
                sender_id: senderId,
                receiver_id: receiverId,
                message: message,
            }),
        });
        messageInput.value = "";
        fetchMessages();
    }
});

// Fetch messages every 2 seconds
setInterval(fetchMessages, 2000);
fetchMessages();

    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>

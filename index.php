<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern ChatBot</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="chat-container">
        <header class="chat-header">
            <div class="header-content">
                <img src="bot-icon.png" alt="ChatBot Icon" class="bot-icon">
                <h1>ChatBot</h1>
            </div>
            <button id="theme-toggle" class="theme-toggle">🌙</button>
        </header>
        <div class="chat-box" id="chat-box">
            <!-- Chat messages will appear here -->
        </div>
        <form id="chat-form" class="chat-form">
            <input type="text" id="user-input" placeholder="Type your message..." autocomplete="off" required />
            <button type="submit" class="send-button">Send</button>
        </form>
    </div>

    <!-- Optional: Loading Spinner -->
    <div id="loading" class="loading hidden">
        <div class="spinner"></div>
    </div>

    <script src="script.js"></script>
</body>
</html>

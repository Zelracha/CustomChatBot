document.addEventListener('DOMContentLoaded', () => {
    const chatForm = document.getElementById('chat-form');
    const chatBox = document.getElementById('chat-box');
    const userInput = document.getElementById('user-input');
    const loading = document.getElementById('loading');
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // Initialize theme based on user's preference or default to light mode
    if (localStorage.getItem('theme') === 'dark') {
        body.classList.add('dark-mode');
        themeToggle.textContent = '☀️'; // Sun icon for light mode
    } else {
        themeToggle.textContent = '🌙'; // Moon icon for dark mode
    }

    // Theme toggle functionality
    themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        if (body.classList.contains('dark-mode')) {
            themeToggle.textContent = '☀️';
            localStorage.setItem('theme', 'dark');
        } else {
            themeToggle.textContent = '🌙';
            localStorage.setItem('theme', 'light');
        }
    });

    // Handle form submission
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = userInput.value.trim();
        if (message === "") return;

        appendMessage('user', message);
        userInput.value = '';
        scrollToBottom();

        // Show loading spinner
        showLoading(true);

        try {
            const response = await fetch('chatbot.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ message }),
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            appendMessage('bot', data.reply);
            scrollToBottom();
        } catch (error) {
            console.error('Error:', error);
            appendMessage('bot', 'Sorry, there was an error processing your request.');
            scrollToBottom();
        } finally {
            // Hide loading spinner
            showLoading(false);
        }
    });

    // Function to append messages to chat box
    function appendMessage(sender, text) {
        const messageElem = document.createElement('div');
        messageElem.classList.add('chat-message', sender);

        const contentElem = document.createElement('div');
        contentElem.classList.add('message-content');
        contentElem.textContent = text;

        messageElem.appendChild(contentElem);
        chatBox.appendChild(messageElem);
    }

    // Function to scroll chat to the bottom
    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Function to show or hide loading spinner
    function showLoading(isLoading) {
        if (isLoading) {
            loading.classList.remove('hidden');
        } else {
            loading.classList.add('hidden');
        }
    }
});

document.addEventListener('DOMContentLoaded', () => {
    const chatOutput = document.getElementById('chat-output');
    const userInput = document.getElementById('user-input');
    const sendBtn = document.getElementById('send-btn');

    function addMessage(content, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
        messageDiv.innerHTML = `<strong>${isUser ? 'You' : 'Bot'}:</strong> ${content}`;
        chatOutput.appendChild(messageDiv);
        chatOutput.scrollTop = chatOutput.scrollHeight;
    }

    async function sendMessage() {
        const message = userInput.value.trim();
        if (!message) return;

        // Clear input and disable button
        userInput.value = '';
        sendBtn.disabled = true;
        sendBtn.textContent = 'Sending...';

        // Add user message
        addMessage(message, true);

        try {
            const response = await fetch('api_proxy.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message })
            });

            const data = await response.json();

            if (data.error) {
                throw new Error(data.message || 'Failed to get response');
            }

            // Add bot response
            const botReply = data.choices[0].message.content;
            addMessage(botReply);

        } catch (error) {
            console.error('Error:', error);
            addMessage(`Error: ${error.message}`, false);
        } finally {
            // Re-enable button
            sendBtn.disabled = false;
            sendBtn.textContent = 'Send';
        }
    }

    // Event listeners
    sendBtn.addEventListener('click', sendMessage);
    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});
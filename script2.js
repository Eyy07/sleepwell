 function toggleChat() {
            const chatBox = document.getElementById('chat-box');
            const chatSupport = document.querySelector('.chat-support');
            if (chatBox.style.display === 'none' || chatBox.style.display === '') {
                chatBox.style.display = 'flex'; // Display chat box as flex
                chatSupport.style.display = 'none'; // Hide chat support bubble
            } else {
                chatBox.style.display = 'none';
                chatSupport.style.display = 'flex'; // Show chat support bubble
            }
        }

        function sendMessage() {
            const chatInput = document.getElementById('chat-input');
            const message = chatInput.value.trim();

            if (message) {
                const chatContent = document.querySelector('.chat-content');

                // Display the user's message
                const userMessageElement = document.createElement('div');
                userMessageElement.classList.add('message', 'sent');
                userMessageElement.innerHTML = `<p>${message}</p>`;
                chatContent.appendChild(userMessageElement);

                chatContent.scrollTop = chatContent.scrollHeight;
                chatInput.value = '';

                // Simulate a response from the chat bot after a short delay
                setTimeout(() => {
                    const botMessageElement = document.createElement('div');
                    botMessageElement.classList.add('message', 'received');
                    botMessageElement.innerHTML = `<p>${getBotResponse(message)}</p>`;
                    chatContent.appendChild(botMessageElement);

                    chatContent.scrollTop = chatContent.scrollHeight;
                }, 1000);
            }
        }

        function sendSuggestion(suggestion) {
            const chatInput = document.getElementById('chat-input');
            chatInput.value = suggestion;
            sendMessage(); // Send the message as if typed by the user
        }

        function getBotResponse(userMessage) {
            // Simple keyword-based response
            const responses = {
                hello: "Hello! How can I help you today?",
                booking: "To book a room, please visit our booking page or contact us with your details.",
                hours: "We are open 24 hours.",
                contact: "You can reach us at apartelle.sleepwell@yahoo.com",
                default: "I'm sorry, I didn't understand that. Can you please provide more details?"
            };

            // Convert user message to lowercase for case-insensitive matching
            const lowerCaseMessage = userMessage.toLowerCase();

            // Check for responses based on keywords in the user's message
            if (lowerCaseMessage.includes('book') || lowerCaseMessage.includes('room')) {
                return responses.booking;
            } else if (lowerCaseMessage.includes('hours')) {
                return responses.hours;
            } else if (lowerCaseMessage.includes('contact')) {
                return responses.contact;
            } else if (lowerCaseMessage.includes('hello')) {
                return responses.hello;
            } else {
                return responses.default;
            }
        }
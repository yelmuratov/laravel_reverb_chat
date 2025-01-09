import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

const currentSessionId = "{{ session()->getId() }}"; // Pass session ID from Blade to JavaScript

window.Echo.channel('test').listen('MessageEvent', (e) => {
    if (e.sender_id === currentSessionId) {
        return; // Ignore the event if it's from the current browser
    }

    const messagesContainer = document.getElementById("messages");
    if (messagesContainer) {
        const messageRow = document.createElement("tr");

        messageRow.innerHTML = `
            <td>
                ${
                    e.message.image_path
                    ? `<img src="http://127.0.0.1:8000/storage/${e.message.image_path}" alt="Uploaded Image" style="width: 100px;">`
                    : "No Image"
                }
            </td>
            <td>
                ${
                    e.message.path_file
                    ? `<a href="http://127.0.0.1:8000/storage/${e.message.path_file}" target="_blank" download>
                        <i class="fas fa-file-download"></i> Download File
                       </a>`
                    : "No File"
                }
            </td>
            <td>${e.message.content ? e.message.content : "No Content"}</td>
        `;

        messagesContainer.appendChild(messageRow);
    }
});




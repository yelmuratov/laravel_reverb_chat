import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: '127.0.0.1', // Change localhost to 127.0.0.1
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8000, // Ensure the port is set correctly
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'], // Specify allowed transports
});

window.Echo.channel('test').listen('MessageEvent', (e) => {
    console.log(e);

    const messagesTable = document.getElementById('messages');
    const existingRows = messagesTable.querySelectorAll('tr');
    const messageIds = Array.from(existingRows).map(row => row.dataset.messageId);

    if (!messageIds.includes(e.message.id.toString())) {
        const newRow = document.createElement('tr');
        newRow.dataset.messageId = e.message.id;

        const imageCell = document.createElement('td');
        if (e.image_path) {
            const img = document.createElement('img');
            img.src = `/storage/${e.image_path}`;
            img.alt = 'Uploaded Image';
            img.style.width = '100px';
            imageCell.appendChild(img);
        } else {
            imageCell.textContent = 'No Image';
        }

        const fileCell = document.createElement('td');
        if (e.path_file) {
            const link = document.createElement('a');
            link.href = `/storage/${e.path_file}`;
            link.target = '_blank';
            link.download = true;
            link.innerHTML = '<i class="fas fa-file-download"></i> Download File';
            fileCell.appendChild(link);
        } else {
            fileCell.textContent = 'No File';
        }

        const contentCell = document.createElement('td');
        contentCell.textContent = e.message.content;

        newRow.appendChild(imageCell);
        newRow.appendChild(fileCell);
        newRow.appendChild(contentCell);

        messagesTable.appendChild(newRow);

        // Update message count
        const messageCount = document.getElementById('message-count');
        messageCount.textContent = parseInt(messageCount.textContent) + 1;
    }
});

const userId = "{{ auth()->id() }}"; // Pass the authenticated user's ID from Blade to JavaScript

window.Echo.private(`private-chat.${userId}`).listen('PrivateMessageEvent', (e) => {
    console.log(e);

    const messagesTable = document.getElementById('messages');
    const existingRows = messagesTable.querySelectorAll('tr');
    const messageIds = Array.from(existingRows).map(row => row.dataset.messageId);

    if (!messageIds.includes(e.message.id.toString())) {
        const newRow = document.createElement('tr');
        newRow.dataset.messageId = e.message.id;

        const imageCell = document.createElement('td');
        if (e.image_path) {
            const img = document.createElement('img');
            img.src = `/storage/${e.image_path}`;
            img.alt = 'Uploaded Image';
            img.style.width = '100px';
            imageCell.appendChild(img);
        } else {
            imageCell.textContent = 'No Image';
        }

        const fileCell = document.createElement('td');
        if (e.path_file) {
            const link = document.createElement('a');
            link.href = `/storage/${e.path_file}`;
            link.target = '_blank';
            link.download = true;
            link.innerHTML = '<i class="fas fa-file-download"></i> Download File';
            fileCell.appendChild(link);
        } else {
            fileCell.textContent = 'No File';
        }

        const contentCell = document.createElement('td');
        contentCell.textContent = e.message.content;

        newRow.appendChild(imageCell);
        newRow.appendChild(fileCell);
        newRow.appendChild(contentCell);

        messagesTable.appendChild(newRow);

        // Update message count
        const messageCount = document.getElementById('message-count');
        messageCount.textContent = parseInt(messageCount.textContent) + 1;
    }
});

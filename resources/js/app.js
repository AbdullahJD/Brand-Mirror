import './bootstrap';
import Echo from 'laravel-echo';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

window.Echo.private('admin.orders')
    .listen('.order.created', (e) => {
        console.log('NEW ORDER:', e);
    });
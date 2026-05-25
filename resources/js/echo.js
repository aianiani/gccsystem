import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

const broadcaster = import.meta.env.VITE_BROADCAST_CONNECTION || 'reverb';

window.Echo = new Echo({
    broadcaster: broadcaster,
    key: broadcaster === 'reverb' ? import.meta.env.VITE_REVERB_APP_KEY : import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: broadcaster === 'pusher' ? import.meta.env.VITE_PUSHER_APP_CLUSTER : undefined,
    wsHost: broadcaster === 'reverb' ? import.meta.env.VITE_REVERB_HOST : undefined,
    wsPort: broadcaster === 'reverb' ? (import.meta.env.VITE_REVERB_PORT ?? 80) : undefined,
    wssPort: broadcaster === 'reverb' ? (import.meta.env.VITE_REVERB_PORT ?? 443) : undefined,
    forceTLS: broadcaster === 'pusher' || (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});


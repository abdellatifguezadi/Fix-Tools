import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

// Simple Pusher configuration
if (typeof window.pusherKey !== 'undefined') {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: window.pusherKey,
        cluster: window.pusherCluster,
        forceTLS: true,
        authEndpoint: '/broadcasting/auth'
    });
    
    console.log('Pusher configured with key:', window.pusherKey);
}

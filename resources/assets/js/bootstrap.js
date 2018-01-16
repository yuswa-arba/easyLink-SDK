
import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: 'http://localhost:6005'
});
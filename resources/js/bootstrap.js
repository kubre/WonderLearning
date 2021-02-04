window._ = require('lodash');

// require('./bebio/jquery');
// require('./bebio/popper');
// require('./bebio/');
// require('./bebio/jquery-ui');
// require('./bebio/jquery.fancybox');
// require('./bebio/owl');
// require('./bebio/jquery.countdown');
// require('./bebio/wow');
// require('./bebio/appear');
// require('./bebio/parallax.min');
// require('./bebio/script');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

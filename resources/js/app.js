import Vue from 'vue';

import store from './store'

import DataTable from './DataTable.vue'

// import Echo from "laravel-echo"

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: false,
//     wsPort: 6001,
//     disabledStats: true,
//     wsHost: window.location.hostname
// });
console.log('Listening..')


new Vue({
    el: '#app',
    components: {
        DataTable
    },
    store
});
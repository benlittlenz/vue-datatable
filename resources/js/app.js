import Vue from 'vue';
require('./bootstrap');

import dataTable from './dataTable.vue'

new Vue({
    el: '#app',
    components: {
        dataTable
    },
});
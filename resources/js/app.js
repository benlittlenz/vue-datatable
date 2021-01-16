import Vue from 'vue';

import store from './store'
require('./bootstrap');

import dataTable from './dataTable.vue'

new Vue({
    el: '#app',
    components: {
        dataTable
    },
    store
});
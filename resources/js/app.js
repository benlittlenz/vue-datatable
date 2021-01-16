import Vue from 'vue';

import store from './store'

import dataTable from './dataTable.vue'

new Vue({
    el: '#app',
    components: {
        dataTable
    },
    store
});
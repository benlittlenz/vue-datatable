import Vue from 'vue';

import store from './store'

import DataTable from './DataTable.vue'

new Vue({
    el: '#app',
    components: {
        DataTable
    },
    store
});
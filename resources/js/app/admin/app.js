import '@babel/polyfill';
import 'es6-promise/auto';

import Vue from 'vue';
import App from '@/components/admin/App.vue';
import router from '@/router/admin';
import '@/bootstrap';
import '@popperjs/core';
import { Sidebar, Alert, Popover } from '@coreui/coreui';
import { Helper } from '@/helper.js';

import Layout from '@/components/admin/grid/Layout.vue';

Vue.prototype.Helper = Helper;
Vue.component('layout', Layout);

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});

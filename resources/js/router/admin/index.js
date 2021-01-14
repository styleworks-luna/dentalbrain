import Vue from 'vue';
import Router from "vue-router";

import Customer from '@/router/admin/customer/index.js';

// pages


Vue.use(Router);

const routes = [
    ...Customer
];

const router = new Router({
    base: '/',
    mode: 'history',
    routes: routes
});

export default router;

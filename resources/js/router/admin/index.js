import Vue from 'vue';
import Router from "vue-router";

import Lecture from '@/router/admin/lecture/index.js';
import Customer from '@/router/admin/customer/index.js';
import User from '@/router/admin/user/index.js';
import Banner from '@/router/admin/banner/index.js';

Vue.use(Router);

const routes = [
    ...Lecture,
    ...Customer,
    ...User,
    ...Banner
];

const router = new Router({
    base: '/',
    mode: 'history',
    routes: routes
});

export default router;

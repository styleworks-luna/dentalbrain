import '@babel/polyfill';
import 'es6-promise/auto';

import Vue from 'vue';
import LectureAll from '@/components/lecture/LectureAll.vue';
import '@/bootstrap';
import { Helper } from '@/helper.js';
import Pagination from 'laravel-vue-pagination';

Vue.prototype.Helper = Helper;

Vue.component('lecture-all', LectureAll);
Vue.component('pagination', Pagination);

const app = new Vue({
    el: '#app'
});

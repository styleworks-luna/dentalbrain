import '@babel/polyfill';
import 'es6-promise/auto';

import Vue from 'vue';
import '@/bootstrap';
import { Helper } from '@/helper.js';
import Pagination from 'laravel-vue-pagination';
import LectureAll from '@/components/lecture/LectureAll.vue';
import Lecture from '@/components/mypage/lecture/Lecture.vue';

Vue.prototype.Helper = Helper;

Vue.component('lecture-all', LectureAll);
Vue.component('lecture', Lecture);
Vue.component('pagination', Pagination);

const app = new Vue({
    el: '#app'
});

import '@babel/polyfill';
import 'es6-promise/auto';

import Vue from 'vue';
import '@/bootstrap';
import { Helper } from '@/helper.js?20220104';
import Pagination from 'laravel-vue-pagination';
import LectureAll from '@/components/lecture/LectureAll.vue';
import Lecture from '@/components/mypage/lecture/Lecture.vue';
import Community from '@/components/community/Community.vue';

Vue.prototype.Helper = Helper;

Vue.component('lecture-all', LectureAll);
Vue.component('lecture', Lecture);
Vue.component('community', Community);
Vue.component('pagination', Pagination);

const app = new Vue({
    el: '#app'
});

import '@babel/polyfill';
import 'es6-promise/auto';

import Vue from 'vue';
import LectureAll from '@/components/lecture/LectureAll.vue';
import '@/bootstrap';
import { Helper } from '@/helper.js';

Vue.prototype.Helper = Helper;

Vue.component('lecture-all', LectureAll);

const app = new Vue({
    el: '#app'
});

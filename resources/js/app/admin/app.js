import '@babel/polyfill';
import 'es6-promise/auto';

import Vue from 'vue';
import App from '@/components/admin/App.vue';
import router from '@/router/admin';
import '@/bootstrap';
import '@popperjs/core';
import { Sidebar, Alert, Popover } from '@coreui/coreui';
import { Helper } from '@/helper.js';
import naver from 'vue-naver-maps';
import ElementUI from 'element-ui';
import { ElementTiptapPlugin } from 'element-tiptap';
import 'element-ui/lib/theme-chalk/index.css';
import 'element-tiptap/lib/index.css';

import Layout from '@/components/admin/grid/Layout.vue';
import Pagination from 'laravel-vue-pagination';

Vue.prototype.Helper = Helper;

Vue.component('layout', Layout);
Vue.component('pagination', Pagination);

Vue.use(naver, {
    clientID: 'bx56ktabzx',
    useGovAPI: false, //공공 클라우드 API 사용 (선택)
    subModules:'' // 서브모듈 (선택)
});

Vue.use(ElementUI);
Vue.use(ElementTiptapPlugin, {
     lang: "ko",
    // spellcheck: false,
});

const app = new Vue({
    el: '#app',
    router,
    render: h => h(App)
});

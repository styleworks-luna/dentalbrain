import Notice from '@/views/admin/customer/Notice.vue';
import NoticeCreate from '@/views/admin/customer/NoticeCreate.vue';
import NoticeEdit from '@/views/admin/customer/NoticeEdit.vue';

const routes = [
    {
        path: '/admin/customer/notice/create',
        name: 'AdminNoticeCreate',
        component: NoticeCreate
    },
    {
        path: '/admin/customer/notice/:page',
        name: 'AdminNotice',
        component: Notice
    },
    {
        path: '/admin/customer/notice/:id/:page',
        name: 'AdminNoticeEdit',
        component: NoticeEdit
    }
];

export default routes;

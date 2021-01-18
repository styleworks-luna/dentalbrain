import Inquire from '@/views/admin/customer/Inquire.vue';
import InquireEdit from '@/views/admin/customer/InquireEdit.vue';

const routes = [
    {
        path: '/admin/customer/inquire',
        name: 'AdminNotice',
        component: Inquire
    },
    {
        path: '/admin/customer/inquire/:id',
        name: 'AdminNoticeEdit',
        component: InquireEdit
    }
];

export default routes;

import Inquire from '@/views/admin/customer/Inquire.vue';
import InquireEdit from '@/views/admin/customer/InquireEdit.vue';

const routes = [
    {
        path: '/admin/customer/inquire/:page',
        name: 'AdminInquire',
        component: Inquire
    },
    {
        path: '/admin/customer/inquire/:id/:page',
        name: 'AdminInquireEdit',
        component: InquireEdit
    }
];

export default routes;

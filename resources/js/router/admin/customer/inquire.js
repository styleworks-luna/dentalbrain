import Inquire from '@/views/admin/customer/Inquire.vue';
import InquireEdit from '@/views/admin/customer/InquireEdit.vue';

const routes = [
    {
        path: '/admin/customer/inquire',
        name: 'AdminInquire',
        component: Inquire
    },
    {
        path: '/admin/customer/inquire/:id',
        name: 'AdminInquireEdit',
        component: InquireEdit
    }
];

export default routes;

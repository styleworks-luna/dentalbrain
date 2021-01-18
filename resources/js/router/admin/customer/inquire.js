import Inquiry from '@/views/admin/customer/Inquiry.vue';
import InquiryEdit from '@/views/admin/customer/InquiryEdit.vue';

const routes = [
    {
        path: '/admin/customer/inquiry',
        name: 'AdminNotice',
        component: Inquiry
    },
    {
        path: '/admin/customer/inquiry/:id',
        name: 'AdminNoticeEdit',
        component: InquiryEdit
    }
];

export default routes;

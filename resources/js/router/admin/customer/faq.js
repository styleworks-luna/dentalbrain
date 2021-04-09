import Faq from '@/views/admin/customer/Faq.vue';
import FaqCreate from '@/views/admin/customer/FaqCreate.vue';
import FaqEdit from '@/views/admin/customer/FaqEdit.vue';

const routes = [
    {
        path: '/admin/customer/faq/create',
        name: 'AdminFaqCreate',
        component: FaqCreate
    },
    {
        path: '/admin/customer/faq/:page',
        name: 'AdminFaq',
        component: Faq
    },
    {
        path: '/admin/customer/faq/:id/:page',
        name: 'AdminFaqEdit',
        component: FaqEdit
    }
];

export default routes;

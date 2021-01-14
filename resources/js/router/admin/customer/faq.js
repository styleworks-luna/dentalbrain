import Faq from '@/views/admin/customer/Faq.vue';

const routes = [
    {
        path: '/admin/customer/faq',
        name: 'AdminFaq',
        component: Faq,

        children: [
            {
                path: 'create',
                name: 'AdminFaqCreate',
                component: Faq
            },
            {
                path: 'create',
                name: 'AdminFaqCreate',
                component: Faq
            },
            {
                path: 'edit/:id',
                name: 'AdminFaqEdit',
                component: Faq
            }
        ]
    }
];

export default routes;

import Sns from '@/views/admin/email/Sns.vue';

const routes = [
    {
        path: '/admin/:id/sns',
        name: 'AdminSns',
        component: Sns
    },
];

export default routes;

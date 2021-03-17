import Email from '@/views/admin/email/Email.vue';

const routes = [
    {
        path: '/admin/:id/email',
        name: 'AdminEmail',
        component: Email
    },
];

export default routes;

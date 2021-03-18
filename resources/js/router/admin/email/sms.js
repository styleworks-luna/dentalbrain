import Sms from '@/views/admin/email/Sms.vue';

const routes = [
    {
        path: '/admin/:id/sms',
        name: 'AdminSms',
        component: Sms
    },
];

export default routes;

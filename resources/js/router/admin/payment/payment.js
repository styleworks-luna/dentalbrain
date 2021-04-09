import Payment from '@/views/admin/payment/Payment.vue';

const routes = [
    {
        path: '/admin/payment/:page',
        name: 'AdminPayment',
        component: Payment
    },
];

export default routes;

import Information from '@/views/admin/certificate/Information.vue';
import History from '@/views/admin/certificate/History.vue';

const routes = [
    {
        path: '/admin/certificate/information',
        name: 'Information',
        component: Information
    },
    {
        path: '/admin/certificate/history',
        name: 'History',
        component: History
    },

];

export default routes;

import Dashboard from '@/views/admin/dashboard/Dashboard.vue';

const routes = [
    {
        path: '/admin/dashboard/:page',
        name: 'AdminDashboard',
        component: Dashboard
    },
];

export default routes;

import Online from '@/views/admin/lecture/Online.vue';
import OnlineCreate from '@/views/admin/lecture/OnlineCreate.vue';

const routes = [
    {
        path: '/admin/lecture/online',
        name: 'AdminOnline',
        component: Online
    },
    {
        path: '/admin/lecture/online/create',
        name: 'AdminOnlineCreate',
        component: OnlineCreate
    },
];

export default routes;

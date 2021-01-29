import Online from '@/views/admin/lecture/Online.vue';
import OnlineCreate from '@/views/admin/lecture/OnlineCreate.vue';
import OnlineEdit from '@/views/admin/lecture/OnlineEdit.vue';
import OnlineStatus from '@/views/admin/lecture/OnlineStatus.vue';

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
    {
        path: '/admin/lecture/online/status',
        name: 'AdminOnlineStatus',
        component: OnlineStatus
    },
    {
        path: '/admin/lecture/online/:id',
        name: 'AdminOnlineEdit',
        component: OnlineEdit
    },
];

export default routes;

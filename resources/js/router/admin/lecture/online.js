import Online from '@/views/admin/lecture/Online.vue';
import OnlineCreate from '@/views/admin/lecture/OnlineCreate.vue';
import OnlineEdit from '@/views/admin/lecture/OnlineEdit.vue';

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
        path: '/admin/lecture/online/edit',
        name: 'AdminOnlineEdit',
        component: OnlineEdit
    },
];

export default routes;

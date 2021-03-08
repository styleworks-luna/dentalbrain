import Online from '@/views/admin/lecture/Online.vue';
import OnlineCreate from '@/views/admin/lecture/OnlineCreate.vue';
import OnlineEdit from '@/views/admin/lecture/OnlineEdit.vue';
import OnlineStudent from '@/views/admin/lecture/OnlineStudent.vue';
import OnlineAdditional from '@/views/admin/lecture/OnlineAdditional.vue';

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
        path: '/admin/lecture/online/:id/student',
        name: 'AdminOnlineStudent',
        component: OnlineStudent
    },
    {
        path: '/admin/lecture/online/:id',
        name: 'AdminOnlineEdit',
        component: OnlineEdit
    },
    {
        path: '/admin/lecture/online/:id/student/additional',
        name: 'AdminOnlineAdditional',
        component: OnlineAdditional,
    },
];

export default routes;

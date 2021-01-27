import Offline from '@/views/admin/lecture/Offline.vue';
import OfflineCreate from '@/views/admin/lecture/OfflineCreate.vue';

const routes = [
    {
        path: '/admin/lecture/offline',
        name: 'AdminOffline',
        component: Offline
    },
    {
        path: '/admin/lecture/offline/create',
        name: 'AdminOfflineCreate',
        component: OfflineCreate
    },
];

export default routes;

import Offline from '@/views/admin/lecture/Offline.vue';
import OfflineCreate from '@/views/admin/lecture/OfflineCreate.vue';
import OfflineEdit from '@/views/admin/lecture/OfflineEdit.vue';
import OfflineStatus from '@/views/admin/lecture/OfflineStatus.vue';

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
    {
        path: '/admin/lecture/offline/status',
        name: 'AdminOfflineStatus',
        component: OfflineStatus
    },
    {
        path: '/admin/lecture/offline/:id',
        name: 'AdminOfflineEdit',
        component: OfflineEdit
    },
];

export default routes;

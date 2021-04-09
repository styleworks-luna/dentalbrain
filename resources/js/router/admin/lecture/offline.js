import Offline from '@/views/admin/lecture/Offline.vue';
import OfflineCreate from '@/views/admin/lecture/OfflineCreate.vue';
import OfflineEdit from '@/views/admin/lecture/OfflineEdit.vue';
import OfflineStudent from '@/views/admin/lecture/OfflineStudent.vue';
import OfflineAdditional from '@/views/admin/lecture/OfflineAdditional.vue';
import OfflineDuplicate from '@/views/admin/lecture/OfflineDuplicate.vue';

const routes = [
    {
        path: '/admin/lecture/offline/:page',
        name: 'AdminOffline',
        component: Offline
    },
    {
        path: '/admin/lecture/offline/create',
        name: 'AdminOfflineCreate',
        component: OfflineCreate
    },
    {
        path: '/admin/lecture/offline/:id/student',
        name: 'AdminOfflineStudent',
        component: OfflineStudent
    },
    {
        path: '/admin/lecture/offline/:id/:page',
        name: 'AdminOfflineEdit',
        component: OfflineEdit
    },
    {
        path: '/admin/lecture/offline/:program_id/:student_id/additional',
        name: 'AdminOfflineAdditional',
        component: OfflineAdditional,
    },
    {
        path: '/admin/lecture/offline/:id/duplicate/:page',
        name: 'AdminOfflineDuplicate',
        component: OfflineDuplicate,
    },
];

export default routes;

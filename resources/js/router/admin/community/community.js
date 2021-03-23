import Community from '@/views/admin/community/Community.vue';
import CommunityEdit from '@/views/admin/community/CommunityEdit.vue';
import CommunityCreate from '@/views/admin/community/CommunityCreate.vue';

const routes = [
    {
        path: '/admin/community',
        name: 'AdminCommunity',
        component: Community
    },
    {
        path: '/admin/community/create',
        name: 'AdminCommunityCreate',
        component: CommunityCreate
    },
    {
        path: '/admin/community/:id',
        name: 'AdminCommunityEdit',
        component: CommunityEdit
    },

];

export default routes;

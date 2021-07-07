import UserMembership from '@/views/admin/user/UserMembership.vue';
import UserMembershipEdit from '@/views/admin/user/UserMembershipEdit.vue';

const routes = [
    {
        path: '/admin/user/membership/:page',
        name: 'AdminUserMembership',
        component: UserMembership
    },
    {
        path: '/admin/user/membership/:id/:page',
        name: 'AdminUserMembershipEdit',
        component: UserMembershipEdit,
    },
];

export default routes;

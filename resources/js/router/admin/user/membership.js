import UserMembership from '@/views/admin/user/UserMembership.vue';

const routes = [
    {
        path: '/admin/user/membership/:page',
        name: 'AdminUserMembership',
        component: UserMembership
    },
];

export default routes;

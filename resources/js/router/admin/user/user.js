import User from '@/views/admin/user/User.vue';
import UserEdit from '@/views/admin/user/UserEdit.vue';

const routes = [
    {
        path: '/admin/user',
        name: 'AdminUser',
        component: User
    },
    {
        path: '/admin/user/:id',
        name: 'AdminUserEdit',
        component: UserEdit
    },
];

export default routes;

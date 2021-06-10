import User from '@/router/admin/user/user.js';
import UserMembership from '@/router/admin/user/membership.js';

const routes = [
    ...User,
    ...UserMembership
];

export default routes;

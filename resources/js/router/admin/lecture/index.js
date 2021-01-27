import Online from '@/router/admin/lecture/online.js';
import Offline from '@/router/admin/lecture/offline.js';
import Question from '@/router/admin/lecture/question.js';

const routes = [
    ...Online,
    ...Offline,
    ...Question,
];

export default routes;

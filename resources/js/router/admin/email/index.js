import Email from '@/router/admin/email/email.js';
import Sns from '@/router/admin/email/sns.js';

const routes = [
    ...Email,
    ...Sns,
];

export default routes;

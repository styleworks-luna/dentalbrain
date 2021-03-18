import Email from '@/router/admin/email/email.js';
import Sms from '@/router/admin/email/sms.js';

const routes = [
    ...Email,
    ...Sms,
];

export default routes;

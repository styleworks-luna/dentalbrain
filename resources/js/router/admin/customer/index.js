import Faq from '@/router/admin/customer/faq.js';
import Notice from '@/router/admin/customer/notice.js';
import Inquire from '@/router/admin/customer/inquire.js';

const routes = [
    ...Faq,
    ...Notice,
    ...Inquire
];

export default routes;

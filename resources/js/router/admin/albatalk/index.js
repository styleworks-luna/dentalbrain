import Recruit from '@/router/admin/albatalk/recruit.js';
import Resume from '@/router/admin/albatalk/resume.js';
import Headhunting from '@/router/admin/albatalk/headhunting.js';
import RecruitPayment from '@/router/admin/albatalk/recruit-payment.js';

const routes = [
    ...Recruit,
    ...Resume,
    ...Headhunting,
    ...RecruitPayment,
];

export default routes;

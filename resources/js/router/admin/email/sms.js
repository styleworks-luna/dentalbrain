import Sms from '@/views/admin/email/Sms.vue';

const routes = [
    {
        path: '/admin/:sort/sms/:id',
        name: 'AdminSms',
        component: Sms,
        props: route => ({
            keyword: route.query.keyword,
            job_name_id: route.query.job_name_id,
            member: route.query.member,
            page: route.query.page,
        })
    },
];

export default routes;

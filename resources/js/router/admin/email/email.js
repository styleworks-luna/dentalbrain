import Email from '@/views/admin/email/Email.vue';

const routes = [
    {
        path: '/admin/:sort/email/:id',
        name: 'AdminEmail',
        component: Email,
        props: route => ({
            keyword: route.query.keyword,
            job_name_id: route.query.job_name_id,
            member: route.query.member,
            page: route.query.page,
        })
    },
];

export default routes;

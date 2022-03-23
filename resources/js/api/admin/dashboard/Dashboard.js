import Send from '@/utils/Send.js';

export default {
    getInquiries() {
        return Send({
            url: '/api/admin/dashboard/inquiries',
            method: 'get',
        });
    },
    getQuestion() {
        return Send({
            url: '/api/admin/dashboard/question',
            method: 'get',
        });
    },
}

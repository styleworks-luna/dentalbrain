import Send from '@/utils/Send.js';

export default {
    getFaqData() {
        return Send({
            url: '/api/admin/customer/faq',
            method: 'get'
        });
    }
}
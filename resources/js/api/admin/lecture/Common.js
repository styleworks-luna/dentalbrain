import Send from '@/utils/Send.js';

export default {
    getCategory() {
        return Send({
            url: '/api/admin/lecture/categories',
            method: 'get'
        });
    },
}

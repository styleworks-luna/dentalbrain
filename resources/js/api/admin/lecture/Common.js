import Send from '@/utils/Send.js';

export default {
    getCategory() {
        return Send({
            url: '/api/admin/lecture/categories',
            method: 'get'
        });
    },
    getAdditional(program_id,user_id) {
        return Send({
            url: `/api/admin/lecture/surveys/${program_id}/${user_id}`,
            method: 'get'
        })
    }
}

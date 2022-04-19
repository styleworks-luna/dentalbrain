import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/recruit',
            method: 'get',
            params: params
        });
    },
    setStatus(id) {
        return Send({
            url: `/api/admin/recruit/${id}/status`,
            method: 'patch'
        });
    }
}

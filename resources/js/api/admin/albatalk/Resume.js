import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/resume',
            method: 'get',
            params: params
        });
    },
}

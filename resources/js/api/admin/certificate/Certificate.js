import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/certificate',
            method: 'get',
            params: params
        });
    },
}

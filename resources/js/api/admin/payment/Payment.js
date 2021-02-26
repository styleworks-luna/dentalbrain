import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/payment',
            method: 'get',
            params: params
        });
    },
}

import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/lecture/online',
            method: 'get',
            params: params
        });
    },
    create(data) {
        return Send({
            url: '/api/admin/lecture/online',
            method: 'post',
            data: data
        });
    },
}

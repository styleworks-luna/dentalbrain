import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/certificate',
            method: 'get',
            params: params
        });
    },
    getCount() {
        return Send({
            url: '/api/admin/certificate/count',
            method: 'get',
        });
    },
    getOptions() {
        return Send({
            url: '/api/admin/certificate/options',
            method: 'get',
        });
    },
}

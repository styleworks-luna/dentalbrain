import Send from '@/utils/Send.js';

export default {
    create(params) {
        return Send({
            url: '/api/admin/certificate/completions',
            method: 'post',
            data: params
        });
    },
}

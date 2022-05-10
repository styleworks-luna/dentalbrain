import Send from '@/utils/Send.js';

export default {
    create(params) {
        return Send({
            url: '/api/admin/certificate/qualifications',
            method: 'post',
            data: params
        });
    },
}

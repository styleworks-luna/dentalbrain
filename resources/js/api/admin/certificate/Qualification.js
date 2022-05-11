import Send from '@/utils/Send.js';

export default {
    create(params) {
        return Send({
            url: '/api/admin/certificate/qualifications',
            method: 'post',
            data: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/certificate/qualifications/${id}`,
            method: 'get',
        })
    },
    update(id,data) {
        return Send({
            url: `/api/admin/certificate/qualifications/${id}`,
            method: 'post',
            data: data,
        })
    }
}

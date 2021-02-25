import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/lecture/question',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/lecture/question/${id}/edit`,
            method: 'get'
        })
    },
    update(id, data) {
        return Send({
            url: `/api/admin/lecture/question/${id}`,
            method: 'post',
            data: data
        });
    },
}

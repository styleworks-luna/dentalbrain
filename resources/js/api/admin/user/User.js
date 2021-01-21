import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/user/',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/user/${id}/edit`,
            method: 'get'
        })
    },
    update(id, data) {
        return Send({
            url: `/api/admin/user/${id}`,
            method: 'put',
            data: data
        });
    },
}

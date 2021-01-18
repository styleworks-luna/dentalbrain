import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/customer/inquiry',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/customer/inquiry/${id}/edit`,
            method: 'get'
        })
    },
    update(id, data) {
        return Send({
            url: `/api/admin/customer/inquiry/${id}`,
            method: 'put',
            data: data
        });
    },
    destroy(id) {
        return Send({
            url: `/api/admin/customer/inquiry/${id}`,
            method: 'delete'
        });
    },
}

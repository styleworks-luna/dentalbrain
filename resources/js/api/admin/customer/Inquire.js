import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/customer/inquire',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/customer/inquire/${id}/edit`,
            method: 'get'
        })
    },
    update(id, data) {
        return Send({
            url: `/api/admin/customer/inquire/${id}`,
            method: 'patch',
            data: data
        });
    },
    destroy(id) {
        return Send({
            url: `/api/admin/customer/inquire/${id}`,
            method: 'delete'
        });
    },
    getCategory() {
        return Send({
            url: '/api/admin/customer/inquire/category',
            method: 'get'
        });
    },
}

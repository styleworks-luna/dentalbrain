import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/customer/faq',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/customer/faq/${id}`,
            method: 'get'
        })
    },
    create(data) {
        return Send({
            url: '/api/admin/customer/faq',
            method: 'post',
            data: data
        });
    },
    update(id, data) {
        return Send({
            url: `/api/admin/customer/faq/${id}`,
            method: 'put',
            data: data
        });
    },
    destroy(id) {
        return Send({
            url: `/api/admin/customer/faq/${id}`,
            method: 'delete'
        });
    },
    setStatus(id) {
        return Send({
            url: `/api/admin/customer/faq/${id}/status`,
            method: 'patch'
        });
    },
    getCategory() {
        return Send({
           url: '/api/admin/customer/faq/category',
           method: 'get'
        });
    }
}

import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/user',
            method: 'get',
            params: params
        });
    },
    getMembership(params) {
        return Send({
            url: '/api/admin/membership',
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
    getCategory() {
        return Send({
            url: '/api/admin/user/category',
            method: 'get'
        });
    },
    findPassword(id) {
        return Send({
            url: `/api/admin/user/find/password/${id}`,
            method: 'post'
        });
    },
    setStatus(id) {
        return Send({
            url: `/api/admin/user/${id}/paid`,
            method: 'patch'
        });
    },
}

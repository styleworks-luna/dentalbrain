import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/banner',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/banner/${id}/edit`,
            method: 'get'
        })
    },
    getCategoryData() {
        return Send({
            url: '/api/admin/banner/category',
            method: 'get'
        })
    },
    create(data) {
        return Send({
            url: '/api/admin/banner',
            method: 'post',
            data: data
        });
    },
    update(id, data) {
        return Send({
            url: `/api/admin/banner/${id}`,
            method: 'put',
            data: data
        });
    },
    destroy(id) {
        return Send({
            url: `/api/admin/banner/${id}`,
            method: 'delete'
        });
    },
    setStatus(id) {
        return Send({
            url: `/api/admin/banner/${id}/status`,
            method: 'patch'
        });
    },
}

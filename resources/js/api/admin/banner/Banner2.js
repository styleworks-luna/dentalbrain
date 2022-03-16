import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/program-banner',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/program-banner/${id}`,
            method: 'get'
        })
    },
    getCategoryData() {
        return Send({
            url: '/api/admin/program-banner/category',
            method: 'get'
        })
    },
    create(data) {
        return Send({
            url: '/api/admin/program-banner',
            method: 'post',
            data: data
        });
    },
    update(id, data) {
        return Send({
            url: `/api/admin/program-banner/${id}`,
            method: 'put',
            data: data
        });
    },
    destroy(id) {
        return Send({
            url: `/api/admin/program-banner/${id}`,
            method: 'delete'
        });
    },
    setStatus(id) {
        return Send({
            url: `/api/admin/program-banner/${id}/status`,
            method: 'patch'
        });
    },
}

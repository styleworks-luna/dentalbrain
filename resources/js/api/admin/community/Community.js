import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/article',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/article/${id}`,
            method: 'get'
        })
    },
    create(data) {
        return Send({
            url: '/api/admin/article',
            method: 'post',
            data: data
        });
    },
    update(id, data) {
        return Send({
            url: `/api/admin/article/${id}`,
            method: 'post',
            data: data
        });
    },
    destroy(id) {
        return Send({
            url: `/api/admin/article/${id}`,
            method: 'delete'
        });
    },
    getCategory() {
        return Send({
            url: `/api/admin/article/categories`,
            method: 'get',
        });
    }
}

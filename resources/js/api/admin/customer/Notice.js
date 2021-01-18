import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/customer/notice',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/customer/notice/${id}/edit`,
            method: 'get'
        })
    },
    create(data) {
        return Send({
            url: '/api/admin/customer/notice',
            method: 'post',
            data: data
        });
    },
    update(id, data) {
        return Send({
            url: `/api/admin/customer/notice/${id}`,
            method: 'put',
            data: data
        });
    },
    destroy(id) {
        return Send({
            url: `/api/admin/customer/notice/${id}`,
            method: 'delete'
        });
    },
    setStatus(id) {
        return Send({
            url: `/api/admin/customer/notice/statusChange/${id}`,
            method: 'patch'
        });
    }
}

import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/lecture/offline',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/lecture/offline/${id}`,
            method: 'get'
        })
    },
    create(data) {
        return Send({
            url: '/api/admin/lecture/offline',
            method: 'post',
            data: data
        });
    },
    update(id, data) {
        return Send({
            url: `/api/admin/lecture/offline/${id}`,
            method: 'put',
            data: data
        });
    },
    destroy(id) {
        return Send({
            url: `/api/admin/lecture/offline/${id}`,
            method: 'delete'
        });
    },
    getStudentsData(id) {
        return Send({
            url: `/api/admin/lecture/offline/${id}/students`,
            method: 'get'
        });
    },
    setStudent(id) {
        return Send({
            url: `/api/admin/lecture/offline/${id}/student`,
            method: 'patch'
        });
    },
}

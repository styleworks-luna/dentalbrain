import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/lecture/online',
            method: 'get',
            params: params
        });
    },
    getEditData(id) {
        return Send({
            url: `/api/admin/lecture/online/${id}`,
            method: 'get'
        })
    },
    create(data) {
        return Send({
            url: '/api/admin/lecture/online',
            method: 'post',
            data: data
        });
    },
    update(id, data) {
        return Send({
            url: `/api/admin/lecture/online/${id}`,
            method: 'put',
            data: data
        });
    },
    destroy(id) {
        return Send({
            url: `/api/admin/lecture/online/${id}`,
            method: 'delete'
        });
    },
    getStudentsData(id) {
        return Send({
            url: `/api/admin/lecture/online/${id}/students`,
            method: 'get'
        });
    },
    setStudent(id) {
        return Send({
            url: `/api/admin/lecture/online/${id}/student`,
            method: 'patch'
        });
    },
}

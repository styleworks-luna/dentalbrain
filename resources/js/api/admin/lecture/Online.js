import Send from '@/utils/Send.js';

export const Online = {
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
    duplicate(id, data) {
        return Send({
            url: `/api/admin/lecture/online/${id}/duplicate`,
            method: 'post',
            data: data
        })
    },
    destroy(id) {
        return Send({
            url: `/api/admin/lecture/online/${id}`,
            method: 'delete'
        });
    },
    setStatus(id) {
        return Send({
            url: `/api/admin/lecture/online/${id}`,
            method: 'patch'
        });
    }
};

export const Student = {
    getStudentsData(id, params) {
        return Send({
            url: `/api/admin/lecture/online/${id}/students`,
            method: 'get',
            params: params
        });
    },
    setStudent(id) {
        return Send({
            url: `/api/admin/lecture/online/${id}/students`,
            method: 'patch'
        });
    }
}

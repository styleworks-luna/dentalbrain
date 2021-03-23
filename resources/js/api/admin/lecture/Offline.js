 import Send from '@/utils/Send.js';

export const Offline = {
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
    duplicate(id,data){
        return Send({
            url: `/api/admin/lecture/offline/${id}`,
            method: 'post',
            data: data
        })
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
    setStatus(id) {
        return Send({
            url: `/api/admin/lecture/offline/${id}`,
            method: 'patch'
        });
    }
};

export const Student = {
    getStudentsData(id, params) {
        return Send({
            url: `/api/admin/lecture/offline/${id}/students`,
            method: 'get',
            params: params
        });
    },
    setStudent(id) {
        return Send({
            url: `/api/admin/lecture/offline/${id}/students`,
            method: 'patch'
        });
    }
};

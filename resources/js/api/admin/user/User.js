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
    getEditMembershipData(id) {
      return Send({
          url: `/api/admin/membership/user/${id}`,
          method: 'get',
      })
    },
    updateMembership(id,data) {
        return Send({
            url: `/api/admin/membership/user/${id}`,
            method: 'post',
            data: data,
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
    getLecture(id, params) {
        return Send({
            url: `/api/admin/membership/user/${id}/students`,
            method: 'get',
            params: params
        });
    },
    getStats(id) {
        return Send({
            url: `/api/admin/membership/user/${id}/students/stat`,
            method: 'get',
        });
    },
}

import Send from '@/utils/Send.js';

export default {
    getData(id,params) {
        return Send({
            url: `/api/admin/lecture/online/${id}/certificate/`,
            method: 'get',
            params: params,
        })
    },
    getCertificateEditData(program_id, id) {
      return Send({
          url: `/api/admin/lecture/online/${program_id}/certificate/qualifications/${id}`,
          method: 'get',
      })
    },
    getCompletionEditData(program_id, id) {
        return Send({
            url: `/api/admin/lecture/online/${program_id}/certificate/completions/${id}`,
            method: 'get',
        })
    },
    handleAllPass(id, params) {
        return Send({
            url: `/api/admin/lecture/online/${id}/certificate`,
            method: 'put',
            params: params,
        })
    },
    handleCertificatePass(certificate_id, params) {
        return Send({
            url: `/api/admin/certificate/qualifications/${certificate_id}`,
            method: 'put',
            params: params,
        })
    },
    handleCompletionPass(certificate_id, params) {
        return Send({
            url: `/api/admin/certificate/completions/${certificate_id}`,
            method: 'put',
            params: params,
        })
    },
}

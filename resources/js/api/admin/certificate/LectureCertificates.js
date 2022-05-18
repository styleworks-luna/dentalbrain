import Send from '@/utils/Send.js';

export default {
    getData(id,params) {
        return Send({
            url: `/api/admin/lecture/${id}/certificate/`,
            method: 'get',
            params: params,
        })
    },
    getCertificateEditData(program_id, id) {
      return Send({
          url: `/api/admin/lecture/${program_id}/certificate/qualifications/${id}`,
          method: 'get',
      })
    },
    getCompletionEditData(program_id, id) {
        return Send({
            url: `/api/admin/lecture/${program_id}/certificate/completions/${id}`,
            method: 'get',
        })
    },
    updateCertificate(program_id, id, data) {
        return Send({
            url: `/api/admin/lecture/${program_id}/certificate/qualifications/${id}`,
            method: 'put',
            data: data,
        })
    },
    updateCompletions(program_id, id, data) {
        return Send({
            url: `/api/admin/lecture/${program_id}/certificate/completions/${id}`,
            method: 'put',
            data: data,
        })
    },
    handleAllPass(id, params) {
        return Send({
            url: `/api/admin/lecture/${id}/certificate`,
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

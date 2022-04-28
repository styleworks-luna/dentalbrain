import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/admin/resume',
            method: 'get',
            params: params
        });
    },
    getRecommendData(id) {
        return Send({
            url: `/api/admin/resume/${id}`,
            method: 'get',
        });
    },
    recommendApply(id, data) {
        return Send({
            url: `/api/admin/resume/${id}/apply`,
            method: 'post',
            data: data
        });
    },
    recommendCancel(id, data) {
        return Send({
            url: `/api/admin/resume/${id}/cancel`,
            method: 'post',
            data: data
        });
    }
}

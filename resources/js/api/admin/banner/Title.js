import Send from '@/utils/Send.js';

export default {
    getData() {
        return Send({
            url: '/api/admin/title-banner',
            method: 'get',
        });
    },
    update(id, data) {
        return Send({
            url: `/api/admin/title-banner/${id}`,
            method: 'put',
            data: data
        })
    },
}

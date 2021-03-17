import Send from '@/utils/Send.js';

export default {
    getData(id) {
        return Send({
            url: `/api/admin/lecture/notification/email/${id}`,
            method: 'get',
        });
    },
    update(data) {
        return Send({
            url: '/api/admin/lecture/notification/email',
            method: 'post',
            data: data
        });
    },
}

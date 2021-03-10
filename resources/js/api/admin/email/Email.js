import Send from '@/utils/Send.js';

export default {
    getData(value,id) {
        return Send({
            url: `/api/admin/lecture/notification/email/${id}`,
            method: 'get',
            params: value
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

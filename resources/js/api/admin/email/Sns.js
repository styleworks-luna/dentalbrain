import Send from '@/utils/Send.js';

export default {
    getData(id,value) {
        return Send({
            url: `/api/admin/lecture/notification/sns/${id}`,
            method: 'get',
            params: value
        });
    },
    update(data) {
        return Send({
            url: '/api/admin/lecture/notification/sns/',
            method: 'post',
            data: data
        });
    },
}

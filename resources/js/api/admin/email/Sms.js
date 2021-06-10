import Send from '@/utils/Send.js';

export default {
    getData(id,value) {
        return Send({
            url: `/api/admin/lecture/notification/sms/${id}`,
            method: 'get',
            params: value
        });
    },
    getUserData(params) {
        return Send({
            url: `/api/admin/user/notification/sms`,
            method: 'get',
            params: params,
        });
    },
    update(data) {
        return Send({
            url: '/api/admin/lecture/notification/sms',
            method: 'post',
            data: data
        });
    },
}

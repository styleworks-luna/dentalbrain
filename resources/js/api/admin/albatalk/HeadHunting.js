import Send from '@/utils/Send.js';

export default {
    getData() {
        return Send({
            url: '/api/admin/head-hunting',
            method: 'get',
        });
    },
    create(url) {
        return Send({
            url: `/api/admin/head-hunting`,
            method: 'post',
            data: {
                'url': url
            }
        });
    },
}

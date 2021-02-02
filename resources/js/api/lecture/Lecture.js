import Send from '@/utils/Send.js';

export default {
    getData(params,value) {
        return Send({
            url: '/api/lectures',
            method: 'get',
            params: {
                params,
                category_id: value
            }
        });
    },
}

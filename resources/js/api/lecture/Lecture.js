import Send from '@/utils/Send.js';

export default {
    getData(value) {
        return Send({
            url: '/api/lectures',
            method: 'get',
            params: {
                category_id: value
            }
        });
    },
}

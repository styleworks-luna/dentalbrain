import Send from '@/utils/Send.js';

export default {
    getData(value) {
        return Send({
            url: '/api/lectures',
            method: 'get',
            params: value
        });
    },
    getCategory() {
        return Send({
            url: '/api/lectures/categories',
            method: 'get',
        });
    },
}

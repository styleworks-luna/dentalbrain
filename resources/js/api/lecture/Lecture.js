import Send from '@/utils/Send.js';

export default {
    getData(value) {
        return Send({
            url: '/api/lectures',
            method: 'get',
            params: value
        });
    },
    getBanner1() {
        return Send({
            url: '/api/lectures/recommend?category_id=5',
            method: 'get',
        });
    },
    getBanner2() {
        return Send({
            url: '/api/lectures/recommend?category_id=6',
            method: 'get',
        });
    },
    getCategory() {
        return Send({
            url: '/api/lectures/categories',
            method: 'get',
        });
    },
}

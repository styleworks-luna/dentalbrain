import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: '/api/articles',
            method: 'get',
            params: params
        });
    },
    getCategory() {
        return Send({
            url: `/api/articles/categories`,
            method: 'get',
        });
    },
    getView(id) {
        return Send({
           url: `/api/articles/${id}`,
           method: 'get'
        });
    },
    postLike(id,data) {
        return Send({
            url: `/api/articles/${id}`,
            method: 'post',
            data: data,
        });
    }
}

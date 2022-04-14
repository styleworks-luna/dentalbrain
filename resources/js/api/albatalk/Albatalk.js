import Send from '@/utils/Send.js';

export default {
    getData(params) {
        return Send({
            url: 'api/albatalk/search',
            method: 'get',
            params: params
        });
    },
}

import Send from '@/utils/Send.js';

export default {
    getData(value) {
        return Send({
            url: '/api/lecturesData',
            method: 'get',
            params: value
        });
    },
}

import Send from '@/utils/Send.js';

export default {
    getData(value) {
        return Send({
            url: '/api/lecturesData',
            method: 'get',
            params: value
        });
    },
    destroy(id,data) {
        return Send({
            url: `/api/lectures/${id}/cancel`,
            method: 'delete',
            params: data,
        });
    },
    destroyManual(id,data) {
        return Send({
            url: `/api/lectures/${id}/cancel-request`,
            method: 'delete',
            params: data,
        });
    },
    getLikeData(params) {
        return Send({
           url: `/api/like-lectures`,
            method: 'get',
            params: params,
        });

    },
    getAlbaTalk(){
        return Send({
            url: '/api/account/recruit',
            method: 'get',
        });
    },
    getMyRecruit(){
        return Send({
            url: '/api/account/applied-resume',
            method: 'get',
        });
    },
    getMyCertificate() {
        return Send({
            url: `/api/certificatesData`,
            method: 'get',
        })
    }
}

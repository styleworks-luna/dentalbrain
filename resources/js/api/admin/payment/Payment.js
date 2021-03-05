import Send from '@/utils/Send.js';

const getData = (params) => {
    return Send({
        url: '/api/admin/payment',
        method: 'get',
        params: params
    });
};

const cancelPayment = (id, studentId, params) => {
    return Send({
        url: `/api/admin/lecture/online/${id}/students/${studentId}`,
        method: 'delete',
        params: params
    });
};

export {
    getData,
    cancelPayment
}

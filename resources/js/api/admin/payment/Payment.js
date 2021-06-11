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

const confirmPayment = (id, studentId, params) => {
    return Send({
        url: `/api/admin/lecture/online/${id}/students/${studentId}`,
        method: 'patch',
        params: params
    });
};
const confirmMembershipPayment = (id) => {
    return Send({
        url: `/api/admin/membership/${id}/confirm`,
        method: 'post',
    });
};

const cancelOfflinePayment = (id, studentId, params) => {
    return Send({
        url: `/api/admin/lecture/offline/${id}/students/${studentId}`,
        method: 'delete',
        params: params
    });
};

const confirmOfflinePayment = (id, studentId, params) => {
    return Send({
        url: `/api/admin/lecture/offline/${id}/students/${studentId}`,
        method: 'patch',
        params: params
    });
};

const revertConfirm = (id, studentId) => {
    return Send({
        url: `/api/admin/payment/${id}/${studentId}/revert`,
        method: 'post',
    });
};

export {
    getData,
    cancelPayment,
    confirmPayment,
    confirmMembershipPayment,
    cancelOfflinePayment,
    confirmOfflinePayment,
    revertConfirm,
}

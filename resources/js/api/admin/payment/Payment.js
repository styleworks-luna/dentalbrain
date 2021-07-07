import Send from '@/utils/Send.js';

const getData = (params) => {
    return Send({
        url: '/api/admin/payment',
        method: 'get',
        params: params
    });
};

// 온라인 프로그램 취소
const cancelPayment = (id, studentId, params) => {
    return Send({
        url: `/api/admin/lecture/online/${id}/students/${studentId}`,
        method: 'delete',
        params: params
    });
};

// 온라인 별도결제 확인
const confirmPayment = (id, studentId, params) => {
    return Send({
        url: `/api/admin/lecture/online/${id}/students/${studentId}`,
        method: 'patch',
        params: params
    });
};

// 유료회원 별도결제 확인
const confirmMembershipPayment = (id) => {
    return Send({
        url: `/api/admin/membership/${id}/confirm`,
        method: 'post',
    });
};

//유료회원 취소
const cancelMembershipPayment = (id,params) => {
    return Send({
        url: `/api/admin/membership/${id}/cancel`,
        method: 'post',
        params: params,
    });
};

// 오프라인 프로그램 취소
const cancelOfflinePayment = (id, studentId, params) => {
    return Send({
        url: `/api/admin/lecture/offline/${id}/students/${studentId}`,
        method: 'delete',
        params: params
    });
};

// 오프라인 프로그램 별도결제 확인
const confirmOfflinePayment = (id, studentId, params) => {
    return Send({
        url: `/api/admin/lecture/offline/${id}/students/${studentId}`,
        method: 'patch',
        params: params
    });
};

// 프로그램 별도결제 REVERT
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
    cancelMembershipPayment,
}

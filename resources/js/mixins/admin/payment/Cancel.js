import PaymentCancelLayer from '@/components/admin/form/PaymentCancelLayer.vue';
import { cancelPayment } from '@/api/admin/payment/Payment.js';
import { revertConfirm } from '@/api/admin/payment/Payment.js';
import { cancelOfflinePayment } from '@/api/admin/payment/Payment.js';
import { cancelMembershipPayment } from '@/api/admin/payment/Payment.js';

export const PaymentCancelMixin = {
    components: {
        'payment-cancel-layer': PaymentCancelLayer
    },
    data() {
        return {
            cancelLayer: false,
            cancelStudentId: '',
            paymentMethod: ''
        }
    },
    methods: {
        // 취소 레이어 팝업 띄우기
        handleSetCancelLayer(studentId, paymentMethod) {

            this.cancelLayer = !this.cancelLayer;
            this.cancelStudentId = studentId || '';
            this.paymentMethod = paymentMethod || '';
            console.log(this.cancelLayer,this.cancelStudentId, this.paymentMethod);
        },
        // 온라인 프로그램 취소
        cancelPayment(params) {
            cancelPayment(this.id, this.cancelStudentId, params).then(res => {
                this.handleSetCancelLayer();
                alert(res.data.message);
                this.getData();
            });
        },
        // 유료회원 취소
        cancelMembershipPayment (params) {
            cancelMembershipPayment(this.id, params).then(res => {
                this.handleSetCancelLayer();
                this.getData();
                alert(res.data.message);
            });
        },
        // 유료회원 별도결제 취소
        cancelMembershipAnotherPayment (params) {
            cancelMembershipPayment(this.id, params).then(res => {
                alert(res.data.message);
                this.getData();
            });
        },
        cancelLecture(studentId, program_id) {
            cancelPayment(program_id ? program_id : this.id, studentId, {}).then(res => {
                alert(res.data.message);
                this.getData();
            });
        },
        cancelOfflinePayment(studentId, program_id) {
            cancelOfflinePayment(program_id ? program_id : this.id, studentId, {}).then(res => {
                alert(res.data.message);
                this.getData();
            });
        },
        revertConfirm(studentId, program_id) {
            revertConfirm(program_id ? program_id : this.id, studentId).then(res => {
                alert(res.data.message);
                this.getData();
            })
        }
    }
};

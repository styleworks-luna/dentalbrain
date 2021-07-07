import PaymentConfirmLayer from '@/components/admin/form/PaymentConfirmLayer.vue';
import { confirmPayment } from '@/api/admin/payment/Payment.js';
import { confirmOfflinePayment } from '@/api/admin/payment/Payment.js';
import { confirmMembershipPayment } from '@/api/admin/payment/Payment.js';

export const PaymentConfirmMixin = {
    components: {
        PaymentConfirmLayer,
    },
    data() {
        return {
            confirmLayer: false,
            confirmStudentId: '',
            confirmProgramId: '',
            is_onlineTo: '',
        }
    },
    methods: {
        handleSetConfirmLayer(studentId, programId) {
            this.confirmLayer = !this.confirmLayer;
            this.confirmStudentId = studentId || '';
            this.confirmProgramId = programId || '';
        },
        confirmPayment(params) {
            confirmPayment(this.id ? this.id : this.confirmProgramId, this.confirmStudentId, params).then(res => {
                this.handleSetConfirmLayer();
                alert('확인이 완료되었습니다.');
                this.getData();
            });
        },
        confirmMembershipPayment(id) {
            confirmMembershipPayment(id).then(res => {
                alert('확인이 완료되었습니다.');
                this.getData();
            });
        },
        confirmOfflinePayment(params) {
            confirmOfflinePayment(this.id ? this.id : this.confirmProgramId, this.confirmStudentId, params).then(res => {
                this.handleSetConfirmLayer();
                alert('확인이 완료되었습니다.');
                this.getData();
            });
        },
        handleSetIsOnline(data) {
            this.is_onlineTo = data;
        },
    }
};

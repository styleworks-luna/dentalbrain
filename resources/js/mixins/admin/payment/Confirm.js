import PaymentConfirmLayer from '@/components/admin/form/PaymentConfirmLayer.vue';
import { confirmPayment } from '@/api/admin/payment/Payment.js';

export const PaymentConfirmMixin = {
    components: {
        PaymentConfirmLayer,
    },
    data() {
        return {
            confirmLayer: false,
            confirmStudentId: '',
        }
    },
    methods: {
        handleSetConfirmLayer(studentId) {
            this.confirmLayer = !this.confirmLayer;
            this.confirmStudentId = studentId || '';
        },
        confirmPayment(params) {
            confirmPayment(this.id, this.confirmStudentId, params).then(res => {
                this.handleSetConfirmLayer();
                alert('확인이 완료되었습니다.');
                this.getData();
            });
        },
    }
};

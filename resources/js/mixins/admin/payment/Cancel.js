import PaymentCancelLayer from '@/components/admin/form/PaymentCancelLayer.vue';
import { cancelPayment } from '@/api/admin/payment/Payment.js';

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
        handleSetCancelLayer(studentId, paymentMethod) {
            this.cancelLayer = !this.cancelLayer;
            this.cancelStudentId = studentId || '';
            this.paymentMethod = paymentMethod || '';
        },
        cancelPayment(params) {
            cancelPayment(this.id, this.cancelStudentId, params).then(res => {
                this.handleSetCancelLayer();
                alert(res.data.message);
                this.getData();
            });
        },
        cancelLecture(studentId) {
            cancelPayment(this.id, studentId, {}).then(res => {
                alert(res.data.message);
                this.getData();
            });
        }
    }
};

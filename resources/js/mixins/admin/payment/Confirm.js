import PaymentConfirmLayer from '@/components/admin/form/PaymentConfirmLayer.vue';
import { cancelPayment } from '@/api/admin/payment/Payment.js';

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
            cancelPayment(this.id, this.confirmStudentId, params).then(res => {
                this.handleSetCancelLayer();
                alert(res.data.message);
                this.getData();
            });
        },
    }
};

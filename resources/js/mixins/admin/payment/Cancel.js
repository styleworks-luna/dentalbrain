import PaymentCancelLayer from '@/components/admin/form/PaymentCancelLayer.vue';
import { cancelPayment } from '@/api/admin/payment/Payment.js';
import { revertConfirm } from '@/api/admin/payment/Payment.js';
import { cancelOfflinePayment } from '@/api/admin/payment/Payment.js';

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

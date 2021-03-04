<template>
    <section class="popup-container">
        <div class="layer" @click="handleSetCancelLayer"></div>

        <article class="popup-wrap">
            <header class="popup-header">
                <h2 class="popup-title">결제 취소</h2>
            </header>

            <section class="popup-content">
                <article>
                    <h4>환불사유</h4>
                    <input type="text"
                           class="form-control"
                           v-model="reason">
                </article>

                <template v-if="checkPaymentMethod">
                    <article>
                        <h4>은행</h4>
                        <input type="text"
                               class="form-control"
                               v-model="bank">
                    </article>
                    <article>
                        <h4>예금주</h4>
                        <input type="text"
                               class="form-control"
                               v-model="holderName">
                    </article>
                    <article>
                        <h4>계좌번호</h4>
                        <input type="text"
                               class="form-control"
                               v-model="accountNumber">
                    </article>
                </template>

                <article class="btn-area">
                    <button class="btn btn-dark text-white"
                            @click="handleSetCancelLayer">닫기</button>
                    <button class="btn btn-danger text-white"
                            @click="handleCancelPayment">결제 취소</button>
                </article>
            </section>
        </article>
    </section>
</template>

<script>
export default {
    name: 'PaymentCancelLayer',
    props: {
        'paymentMethod': String
    },
    data() {
        return {
            reason: '',
            bank: '',
            holderName: '',
            accountNumber: ''
        }
    },
    computed: {
        checkPaymentMethod() {
            return this.paymentMethod === '가상계좌';
        }
    },
    methods: {
        handleCancelPayment() {
            const params = {
                reason: this.reason
            };

            if (this.paymentMethod === '가상계좌') {
                params.bank = this.bank;
                params.holderName = this.holderName;
                params.accountNumber = this.accountNumber;
            }

            this.$emit('cancelPayment', params);
        },
        handleSetCancelLayer() {
            this.$emit('setCancelLayer');
        }
    }
}
</script>

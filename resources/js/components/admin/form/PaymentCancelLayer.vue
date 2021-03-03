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
                           @input="handleSetReason">
                </article>

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
        reason: String
    },
    methods: {
        handleSetReason(e) {
            this.$emit('setReason', e.target.value);
        },
        handleCancelPayment() {
            this.$emit('cancelPayment');
        },
        handleSetCancelLayer() {
            this.$emit('setCancelLayer');
        }
    }
}
</script>

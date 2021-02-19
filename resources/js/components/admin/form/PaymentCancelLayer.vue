<template>
    <div>
        <input type="text"
               @input="handleSetReason">
        <button class="btn">닫기</button>
        <button class="btn btn-danger text-white" @click="handleCancelPayment">결제 취소</button>
    </div>
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
        }
    }
}

</script>

<style>

</style>

<template>
    <section class="popup-container">
        <div class="layer" @click="handleSetConfirmLayer"></div>

        <article class="popup-wrap">
            <header class="popup-header">
                <h2 class="popup-title">계좌입금 확인</h2>
            </header>

            <section class="popup-content">
                <article class="date-wrap" v-if="is_online">
                    <date-picker class="mr-3 w-100"
                                 :time="date"
                                 :placeholder="'시청마감일자를 입력해주세요.'"
                                 @setTime="handleSetDate"></date-picker>
                </article>

                <article class="btn-area">
                    <button class="btn btn-dark text-white"
                            @click="handleSetConfirmLayer">닫기</button>
                    <button class="btn btn-success text-white"
                            @click="handleConfirmPayment">결제 확인</button>
                </article>
            </section>
        </article>
    </section>
</template>

<script>
import DatePicker from '@/components/common/DatePicker.vue'

export default {
    name: 'PaymentConfirmLayer',
    components: {
        DatePicker,
    },
    props: {
      "is_online": Number,
    },
    data() {
        return {
            date: '',
        }
    },
    methods: {
        handleSetDate(time) {
            this.date =  time;
        },
        handleConfirmPayment() {
            const params = {
                date: this.Helper.dateFormatYDM(this.date),
            };

            this.$emit('confirmPayment', params);
        },
        handleSetConfirmLayer() {
            this.$emit('setConfirmLayer');
        }
    }
}
</script>

<template>
    <section class="popup-container">
        <div class="layer" @click="handleSetConfirmLayer"></div>

        <article class="popup-wrap">
            <header class="popup-header">
                <h2 class="popup-title">별도결제 확인</h2>
            </header>

            <section class="popup-content">
                <article>
                    <date-picker class="mr-3"
                                 :time="date"
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
                date: this.Helper.dateFormatYMD(this.date),
            };

            this.$emit('confirmPayment', params);
        },
        handleSetConfirmLayer() {
            this.$emit('setConfirmLayer');
        }
    }
}
</script>

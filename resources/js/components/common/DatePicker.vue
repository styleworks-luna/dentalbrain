<template>
        <datepicker class="date-picker float-left"
                    valueType="format"
                    :format="'yyyy-MM-dd'"
                    :language="ko"
                    :required="true"
                    input-class="datepicker form-control"
                    @input="handleSetDate"
                    v-model="date"
                    placeholder="날짜를 입력해주세요."></datepicker>
</template>

<script>
// components
import Datepicker from 'vuejs-datepicker';
import {ko} from 'vuejs-datepicker/dist/locale';

export default {
    name: 'DatePicker',
    components: {
        Datepicker,
    },
    props: {
        'time': [String, Date],
    },
    data() {
        return {
            ko: ko,
            date: ''
        };
    },
    watch: {
        time() {
            this.date = this.time;
        }
    },
    methods: {
        handleSetDate() {
            this.$emit('setTime', this.date);
        }
    }
}

</script>

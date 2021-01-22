<template>
    <div>
        <datepicker class="date-picker start-time float-left"
                    valueType="format"
                    :format="'yyyy-MM-dd'"
                    :language="ko"
                    :required="true"
                    input-class="datepicker form-control"
                    @input="handleSetTime"
                    v-model="date"></datepicker>
    </div>
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
        nullCheck(value) {
            return value == '' || value == null || value == undefined || value == 'undefined';
        },
        dateFormat(date) {
            if (this.nullCheck(date)) {
                return '';
            }

            date = new Date(date);
            const year = date.getFullYear();
            let month = date.getMonth() + 1;
            let day = date.getDate();

            if (month < 10) {
                month = `0${month}`;
            }

            if (day < 10) {
                day = `0${day}`;
            }

            return `${year}-${month}-${day}`;
        },
        handleSetTime() {
            this.$emit('setTime', this.date);
        }
    }
}

</script>

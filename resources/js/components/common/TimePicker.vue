<template>
    <vue-timepicker class="timepicker float-left"
                valueType="format"
                format="HH:mm"
                :required="true"
                :disabled="disabled"
                input-class="timepicker form-control"
                @input="handleSetTime"
                v-model="date"></vue-timepicker>
</template>

<script>
// components
import VueTimepicker from 'vue2-timepicker'
import 'vue2-timepicker/dist/VueTimepicker.css'

export default {
    name: 'TimePicker',
    components: {
        VueTimepicker,
    },
    props: {
        'time': [String, Date],
        'disabled': Boolean,
    },
    data() {
        return {
            date: ''
        };
    },
    watch: {
        time() {
            this.date = this.time;
        }
    },
    methods: {
        handleSetTime() {
            this.$emit('setTime', this.date);
        }
    }
}

</script>

<template>
    <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-info">
        <input type="checkbox" class="c-switch-input"
              v-model="check"
              @change="checkEvent">
        <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
    </label>
</template>

<script>
    export default {
        name: 'AdminButtonCheck',
        props: {
            'propsCheck': [Number, Boolean]
        },
        data () {
            return {
                check: false
            }
        },
        mounted() {
            this.check = this.propsCheck;
        },
        watch: {
            propsCheck() {
                this.check = this.propsCheck;
            }
        },
        methods: {
            checkEvent () {
                this.$emit('isChecked', this.check);
            }
        }
    }
</script>

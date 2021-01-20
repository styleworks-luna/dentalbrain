<template>
    <select @change="handleSetValue($event.target.value)">
        <option value=""
                v-if="!Helper.nullCheck(text)">{{ text }}</option>

        <option v-for="(option, index) in options"
                :value="option.id"
                :selected="isSelected(option.id)">
            {{ option.name }}
        </option>
    </select>
</template>

<script>
    export default {
        name: 'SelectBox',
        props: {
            'text': String,
            'value': [Number, String, Boolean],
            'options': Array
        },
        methods: {
            isSelected(value) {
                return value == this.value;
            },
            handleSetValue(value) {
                this.$emit('setValue', value);
            }
        }
    }
</script>

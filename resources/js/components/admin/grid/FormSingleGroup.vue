<template>
    <div class="form-group row">
        <label class="col-md-2 col-form-label">
            {{ name }} <span v-if="isRequired" class="text-danger">*</span>
        </label>
        <div :class="checkSize">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FormGroup',
        props: {
            name: String,
            isRequired: Boolean,
            size: Number
        },
        computed: {
            checkSize() {
                if (this.size) {
                    let result = {};
                    result[`col-md-${this.size}`] = true;
                    return result
                } else {
                    return { 'col-md-6': true }
                }
            }
        }
    }
</script>

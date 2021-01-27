<template>
    <div class="form-group"
         :class="{ 'row': isRow }">
        <label class="col-form-label"
               :class="labelSize">
            {{ name }} <span v-if="isRequired" class="text-danger">*</span>
        </label>
        <div :class="contentSize" class="form-input">
            <slot name="content"></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FormGroup',
        props: {
            name: String,
            isRow: Boolean,
            isRequired: Boolean,
            size: Number
        },
        computed: {
            labelSize() {
                let result = {};

                if (this.size) {
                    result[`col-md-2`] = true;
                }

                return result;
            },
            contentSize() {
                let result = {};

                if (this.size) {
                    result[`col-md-${this.size}`] = true;
                }

                return result;
            }
        }
    }
</script>

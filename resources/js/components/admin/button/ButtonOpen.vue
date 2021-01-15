<template>
    <button type="button"
            class="btn btn-block btn-outline-dark"
            :class="checkIsOpen">
        <template v-if="isOpen">공개</template>
        <template v-else>비공개</template>
    </button>
</template>

<script>
    export default {
        name: 'AdminButtonIcon',
        props:['isOpen'],
        computed: {
            checkIsOpen() {
                return {
                    'btn-outline-dark': this.isOpen,
                    'btn-outline-danger': !this.isOpen
                }
            }
        }
    }
</script>

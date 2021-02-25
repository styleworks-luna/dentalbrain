<template>
    <button type="button"
            class="btn"
            :class="checkIsOpen"
            @click="setStatus">
        <div v-if="anotherText == 'question'">
            <template v-if="isOpen">완료</template>
            <template v-else>미완료</template>
        </div>
        <div v-else>
            <template v-if="isOpen">공개</template>
            <template v-else>비공개</template>
        </div>
    </button>
</template>

<script>
export default {
    name: 'AdminButtonIcon',
    props: {
        'anotherText': String,
        'isOpen': [Number, Boolean]
    },
    computed: {
        checkIsOpen() {
            return {
                // 'btn-outline-dark': this.isOpen,
                // 'btn-outline-danger': !this.isOpen
            }
        }
    },
    methods: {
        setStatus() {
            this.$emit('setStatus');
        }
    }
}
</script>

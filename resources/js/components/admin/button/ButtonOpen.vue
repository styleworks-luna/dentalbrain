<template>
    <button type="button"
            class="btn"
            :class="checkIsOpen"
            @click="setStatus">
        <template v-if="anotherText === 'question'">
            <template v-if="isOpen">완료</template>
            <template v-else>미완료</template>
        </template>
        <template v-else-if="anotherText === 'paid'">
            <template v-if="isOpen">유료</template>
            <template v-else>무료</template>
        </template>
        <template v-else>
            <template v-if="isOpen">공개</template>
            <template v-else>비공개</template>
        </template>
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

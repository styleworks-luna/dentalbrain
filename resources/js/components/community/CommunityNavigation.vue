<template>
    <div class="community-menu">
        <ul>
            <li :class="{'active-menu': isActive == 1}" @click="handleSetMenu(1,1)">전체</li>
            <li :class="{'active-menu': isActive == 2}" @click="handleSetMenu(2,2)">컨설턴트컬럼</li>
            <li :class="{'active-menu': isActive == 3}" @click="handleSetMenu(3,3)">스페셜인터뷰</li>
            <li :class="{'active-menu': isActive == 4}" @click="handleSetMenu(4,4)">신제품리뷰</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isActive: 1,
        }
    },
    created() {
        this.setActive();
    },
    methods: {
        handleSetMenu(value, active) {
            this.isActive = active
            this.$emit('setMenu', value);
        },
    }
}
</script>

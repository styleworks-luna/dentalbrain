<template>
    <div class="lecture-order">
        <ul>
            <li><a href="" :class="{ 'active': is_active == 1}" @click.prevent="handleSetOrder('newest',1)">최신순</a></li>
            <li><a href="" :class="{ 'active': is_active == 2}" @click.prevent="handleSetOrder('popular',2)">인기순</a></li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            is_active: 1,
        }
    },
    methods: {
        handleSetOrder(order,active) {
            this.is_active = active;
            this.$emit('setOrder',order);
        },
    }
}

</script>

<style>

</style>

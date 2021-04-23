<template>
    <div class="community-order">

        <template v-if="mobile">
            <select class="community-order-select" v-model="order_id" @change="handleSetOrderSelect">
                <option value="newest" selected>최신순</option>
                <option value="newest">인기순</option>
            </select>

        </template>
        <template v-else>
            <ul>
                <li><a href="" :class="{ 'active': is_active == 1}" @click.prevent="handleSetOrder('newest',1)">최신순</a></li>
                <li><a href="" :class="{ 'active': is_active == 2}" @click.prevent="handleSetOrder('popular',2)">인기순</a></li>
            </ul>
        </template>

    </div>
</template>

<script>
export default {
    data() {
        return {
            is_active: 1,
            order_id: 'newest',
        }
    },
    props: {
        'mobile': Boolean,
    },
    methods: {
        handleSetOrder(order,active) {
            this.is_active = active;
            this.$emit('setOrder',order);
        },
        handleSetOrderSelect() {
            this.$emit('setOrder', this.order_id);
        }
    }
}
</script>

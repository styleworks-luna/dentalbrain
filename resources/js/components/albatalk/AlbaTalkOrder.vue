<template>
    <div class="albatalk-order">
        <template v-if="mobile">
        <div class="m-row">
            <ul class="order-list">
                <li>
                    <a href="" class="btn-menu" @click.prevent="show()">
                        <span>근무지역</span>
                        <span id="icon_filter" class="icon-filter"></span>
                    </a>
                </li>
                <li>
                    <select id="albatalk-order-select" class="albatalk-order-select" v-model="order" @change="orderMobileHandle">
                        <option value="newest" selected>등록일순</option>
                        <option value="closest">마감일순</option>
                    </select>
                </li>
            </ul>
        </div>
        </template>
        <template v-else>
            <h2>구인정보</h2>
            <ul>
                <li><a href="" :class="{ 'active': is_active == 1}" @click.prevent="orderHandle('newest',1)">등록일순</a></li>
                <li><a href="" :class="{ 'active': is_active == 2}" @click.prevent="orderHandle('closest',2)">마감일순</a></li>
            </ul>
        </template>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkOrder",
    props: {
        'mobile': Boolean,
    },
    data() {
      return {
          order: "newest",
          is_active: 1
      }
    },
    methods: {
        show(){
            document.getElementById("albatalk-menu").style.display='block';
        },
        orderHandle(order, active) {
            this.is_active = active
            this.order = order;
            this.$emit('orderEmit',this.order);
        },
        orderMobileHandle() {
            this.$emit('orderEmit',this.order)
        },
    }
}

</script>

<style>

</style>

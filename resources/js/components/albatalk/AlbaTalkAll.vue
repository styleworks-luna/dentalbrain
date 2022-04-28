<template>
    <section class="albatalk">
        <div class="albatalk-navigation">
            <albatalk-order :mobile="mobile" @orderEmit="orderUpdate"></albatalk-order>
            <albatalk-navigation :mobile="mobile" :show="showNavigation" @menuEventEmit="menuListUpdate"></albatalk-navigation>
        </div>
        <albatalk-list :mobile="mobile" :lists="lists"></albatalk-list>
    </section>
</template>

<script>
import AlbaTalkList from '@/components/albatalk/AlbaTalkList.vue';
import AlbaTalkNavigation from '@/components/albatalk/AlbaTalkNavigation.vue';
import AlbaTalkOrder from '@/components/albatalk/AlbaTalkOrder.vue';

// api
import Albatalk from "@/api/albatalk/Albatalk.js"

export default {
    name: "AlbaTalk",
    components: {
        'albatalk-list': AlbaTalkList,
        'albatalk-order': AlbaTalkOrder,
        'albatalk-navigation': AlbaTalkNavigation,
    },
    props: {
        'is_navigation': Boolean,
        'is_order': Boolean,
        "mobile": Boolean,
    },
    data() {
        return {
            updatedMenuList: [],
            updateOrder: 'newest',
            lists: [],
            showNavigation: false,
        }
    },
    methods: {
        getData() {
            let params = {
                sido: this.updatedMenuList,
                order: this.updateOrder,
            }
            Albatalk.getData(params).then(res => {
                this.lists = res.data;
            })
        },
        menuListUpdate(menuList) {
            this.updatedMenuList = menuList;
            this.getData();
        },
        orderUpdate(order) {
            this.updateOrder = order;
            this.getData();
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <section class="community">
        <div class="community-navigation">
            <community-navigation @setMenu="handleSetMenu"></community-navigation>
            <community-order @setOrder="handleSetOrder"></community-order>
        </div>
        <community-list></community-list>
    </section>
</template>

<script>
import CommunityNavigation from '@/components/community/CommunityNavigation.vue';
import CommunityOrder from '@/components/community/CommunityOrder.vue';
import CommunityList from '@/components/community/CommunityList.vue';

export default {
    name: 'Community',
    components: {
        CommunityList,
        CommunityNavigation,
        CommunityOrder,
    },
    data() {
        return {
            category_id: 1,
            list: {},
            order_by: 'newest',
            page: 1
        }
    },
    mounted() {
        // this.getData();
    },
    methods: {
        handleSetMenu(category_id) {
            this.category_id = category_id;
            console.log(this.category_id);
            // this.getData()
        },
        handleSetOrder(order_by) {
            this.order_by = order_by;
            console.log(this.order_by);
            // this.getData()
        },
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                category_id: this.category_id,
                per_page: this.per_page,
                order_by: this.order_by,
                page: page
            };

            Lecture.getData(params).then(res => {
                this.list = res.data;
            }).catch(err => {
                this.list = [];
            });
        },
    }
}
</script>

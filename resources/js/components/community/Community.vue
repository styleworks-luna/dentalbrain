<template>
    <section class="community">
        <div class="community-navigation">
            <community-navigation @setMenu="handleSetMenu"></community-navigation>
            <community-order @setOrder="handleSetOrder"></community-order>
        </div>
        <community-list :list="list.data"></community-list>

        <div class="paging-wrap">
            <nav>
                <pagination :data="list" :limit=3 @pagination-change-page="getData">
                    <span slot="prev-nav" class="prev-nav ir_pm">prev</span>
                    <span slot="next-nav" class="next-nav ir_pm">next</span>
                </pagination>
            </nav>
        </div>
    </section>
</template>

<script>
// component
import CommunityNavigation from '@/components/community/CommunityNavigation.vue';
import CommunityOrder from '@/components/community/CommunityOrder.vue';
import CommunityList from '@/components/community/CommunityList.vue';

// api
import Community from '@/api/community/Community.js'

export default {
    name: 'Community',
    components: {
        CommunityList,
        CommunityNavigation,
        CommunityOrder,
    },
    data() {
        return {
            category_id: '',
            list: {},
            order_by: 'newest',
            page: 1
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        handleSetMenu(category_id) {
            this.category_id = category_id;
            this.getData()
        },
        handleSetOrder(order_by) {
            this.order_by = order_by;
            this.getData()
        },
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                category: this.category_id,
                sort: this.order_by,
                page: page
            };

            Community.getData(params).then(res => {
                this.list = res.data;
            }).catch(err => {
                this.list = [];
            });
        },
    }
}
</script>

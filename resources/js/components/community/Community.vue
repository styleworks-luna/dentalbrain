<template>
    <section class="community">
        <div class="community-navigation">
            <community-navigation @setMenu="handleSetMenu" :mobile="mobile"></community-navigation>
            <community-order @setOrder="handleSetOrder" :mobile="mobile"></community-order>
        </div>

        <community-list :list="mobile ? mobileList : list.data"></community-list>

        <template v-if="!mobile">
        <div class="paging-wrap">
            <nav>
                <pagination :data="list" :limit=3 @pagination-change-page="getData">
                    <span slot="prev-nav" class="prev-nav ir_pm">prev</span>
                    <span slot="next-nav" class="next-nav ir_pm">next</span>
                </pagination>
            </nav>
        </div>
        </template>

        <template v-else>
            <div class="infinite-wrapper">
                <infinite-loading @distance="1" :identifier="infiniteId" @infinite="infiniteHandler" force-use-infinite-wrapper></infinite-loading>
            </div>
        </template>
    </section>
</template>

<script>
// component
import CommunityNavigation from '@/components/community/CommunityNavigation.vue';
import CommunityOrder from '@/components/community/CommunityOrder.vue';
import CommunityList from '@/components/community/CommunityList.vue';
import InfiniteLoading from 'vue-infinite-loading';

// api
import Community from '@/api/community/Community.js'

export default {
    name: 'Community',
    components: {
        CommunityList,
        CommunityNavigation,
        CommunityOrder,
        InfiniteLoading,
    },
    props: {
        'mobile': Boolean,
    },
    data() {
        return {
            category_id: '',
            list: {},
            order_by: 'newest',
            page: 1,
            mobileList: [],
            infiniteId: +new Date(),
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        handleSetMenu(category_id) {
            this.category_id = category_id;
            this.getData()
            this.changeType()
        },
        handleSetOrder(order_by) {
            this.order_by = order_by;
            this.getData()
            this.changeType()
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
        infiniteHandler($state, page = this.page) {
            let vm = this;

            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                category: this.category_id,
                sort: this.order_by,
                page: page
            };
            Community.getData(params).then(res => {
                if(res.data.data.length) {
                    $.each(res.data.data, function (key, value) {
                        vm.mobileList.push(value);
                    });
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });

            this.page = this.page + 1;
        },
        changeType() {
            this.page = 1;
            this.mobileList = [];
            this.infiniteId += 1;
        },
    }
}
</script>

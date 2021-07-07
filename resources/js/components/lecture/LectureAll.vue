<template>
    <section class="lecture">
        <lecture-navigation @setMenu="handleSetMenu"></lecture-navigation>
        <lecture-order v-if="is_pagination" @setOrder="handleSetOrder"></lecture-order>
        <lecture-list :list="mobile ? mobileList : list.data"></lecture-list>

        <template v-if="!mobile">
        <div class="paging-wrap" v-if="is_pagination">
            <nav>
                <pagination :data="list" :limit=3 @pagination-change-page="getData">
                    <span slot="prev-nav" class="prev-nav ir_pm">prev</span>
                    <span slot="next-nav" class="next-nav ir_pm">next</span>
                </pagination>
            </nav>
        </div>
        </template>
        <template v-else>
            <div class="infinite-wrapper" v-if="is_pagination">
                <infinite-loading @distance="1" :identifier="infiniteId" @infinite="infiniteHandler" force-use-infinite-wrapper>
                    <div slot="no-more"></div>
                </infinite-loading>
            </div>
        </template>
    </section>
</template>

<script>
import LectureNavigation from '@/components/lecture/LectureNavigation.vue';
import LectureList from '@/components/lecture/LectureList.vue';
import LectureOrder from '@/components/lecture/LectureOrder.vue';
import InfiniteLoading from 'vue-infinite-loading';

// api
import Lecture from '@/api/lecture/Lecture.js'

export default {
    name: 'Lecture',
    components: {
        'lecture-navigation': LectureNavigation,
        'lecture-list': LectureList,
        'lecture-order': LectureOrder,
        InfiniteLoading,
    },
    props: {
        'is_pagination': Boolean,
        'per_page': Number,
        'mobile': Boolean,
    },
    data() {
        return {
            category_id: 1,
            list: {},
            order_by: 'newest',
            page: 1,
            mobileList: [],
            infiniteId: +new Date(),
        }
    },
    mounted() {
        this.getData();
        alert('test');
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
        },
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            var keyword = document.location.search.replace("?keyword=", "").replaceAll("+", " ");
            keyword = decodeURIComponent(keyword);

            if(keyword.length > 0) {
                document.querySelector('.search-text').innerText = '‘' + keyword + '’';
            }

            let params = {
                category_id: this.category_id,
                per_page: this.per_page,
                order_by: this.order_by,
                keyword: keyword ? keyword : null,
                page: page
            };

            Lecture.getData(params).then(res => {
                this.list = res.data;
            }).catch(err => {
                this.list = [];
            });
        },
        infiniteHandler($state, page = this.page) {
            let vm = this;

            var keyword = document.location.search.replace("?keyword=", "").replaceAll("+", " ");
            keyword = decodeURIComponent(keyword);

            if(keyword.length > 0) {
                document.querySelector('.search-text').innerText = '‘' + keyword + '’';
            }

            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                category_id: this.category_id,
                per_page: this.per_page,
                order_by: this.order_by,
                keyword: keyword ? keyword : null,
                page: page
            };
            Lecture.getData(params).then(res => {
                if(res.data.data.length) {
                    $.each(res.data.data, function (key, value) {
                        vm.mobileList.push(value);
                    });
                    $state.loaded();
                } else {
                    $state.complete();
                }
            }).catch(err => {
                alert(err);
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

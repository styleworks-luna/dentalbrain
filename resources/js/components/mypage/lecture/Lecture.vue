<template>
    <div>
        <div>
            <lecture-order @setOrder="handleSetOrder" :mobile="mobile" :like="like"></lecture-order>
            <lecture-list v-if="!like" :list="mobile ? mobileList : list.data" :mobile="mobile"></lecture-list>
            <template v-else>
                <lecture-like-list :listData="mobile ? mobileLikeList : likeList.data" :mobile="mobile"></lecture-like-list>
            </template>
        </div>

        <template v-if="!mobile">
            <template v-if="!like">
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
                <div class="paging-wrap">
                    <nav>
                        <pagination :data="likeList" :limit=3 @pagination-change-page="getLikeData">
                            <span slot="prev-nav" class="prev-nav ir_pm">prev</span>
                            <span slot="next-nav" class="next-nav ir_pm">next</span>
                        </pagination>
                    </nav>
                </div>
            </template>
        </template>

        <template v-else>
            <template v-if="!like">
                <div class="infinite-wrapper">
                    <infinite-loading @distance="1" :identifier="infiniteId" @infinite="infiniteHandler"
                                      force-use-infinite-wrapper></infinite-loading>
                </div>
            </template>
            <template v-else>
                <div class="infinite-wrapper">
                    <infinite-loading @distance="1" :identifier="infiniteLikeId" @infinite="infiniteLikeHandler"
                                      force-use-infinite-wrapper></infinite-loading>
                </div>
            </template>
        </template>
    </div>
</template>

<script>
import LectureList from '@/components/mypage/lecture/LectureList.vue';
import LectureLikeList from '@/components/mypage/lecture/LectureLikeList.vue';
import LectureOrder from '@/components/mypage/lecture/LectureOrder.vue';
import InfiniteLoading from 'vue-infinite-loading';

// api
import Mypage from '@/api/mypage/Mypage.js';

export default {
    name: 'MypageLecture',
    components: {
        'lecture-list': LectureList,
        'lecture-order': LectureOrder,
        LectureLikeList,
        InfiniteLoading,
    },
    props: {
        'mobile': Boolean,
        'like': Boolean,
    },
    data() {
        return {
            list: {},
            likeList: {},
            order: 'newest',
            page: 1,
            mobileList: [],
            mobileLikeList: [],
            infiniteId: +new Date(),
            infiniteLikeId: 'like' + new Date(),
        }
    },
    mounted() {
        this.getData();
        this.getLikeData();
    },
    methods: {
        handleSetOrder(order) {
            this.order = order;
            if (this.like) {
                this.getLikeData();
            } else {
                this.getData();
            }
            this.changeType();
        },
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                per_page: this.per_page,
                order: this.order,
                page: page
            };

            Mypage.getData(params).then(res => {
                this.list = res.data.data;
            }).catch(err => {
                this.list = [];
            });
        },
        getLikeData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                order: this.order,
                page: page
            };

            Mypage.getLikeData(params).then(res => {
                this.likeList = res.data;
            }).catch(err => {
                this.likeList = [];
            });
        },
        infiniteHandler($state, page = this.page) {
            let vm = this;

            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                per_page: this.per_page,
                order: this.order,
                page: page
            };

            Mypage.getData(params).then(res => {
                if (res.data.data.data.length) {
                    $.each(res.data.data.data, function (key, value) {
                        vm.mobileList.push(value);
                    });
                    $state.loaded();
                } else {
                    $state.complete();
                }
            });

            this.page = this.page + 1;
        },
        infiniteLikeHandler($state, page = this.page) {
            let vm = this;

            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                order: this.order,
                page: page
            };

            Mypage.getLikeData(params).then(res => {
                if (res.data.data.length) {
                    $.each(res.data.data, function (key, value) {
                        vm.mobileLikeList.push(value);
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
            this.mobileLikeList = [];
            this.infiniteId += 1;
            this.infiniteLikeId += 1;
        },
    },
}
</script>

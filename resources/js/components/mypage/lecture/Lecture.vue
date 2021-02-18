<template>
    <div>
        <div>
            <lecture-order @setOrder="handleSetOrder"></lecture-order>
            <lecture-list :list="list.data"></lecture-list>
        </div>

        <div class="paging-wrap">
            <nav>
                <pagination :data="list" :limit=3 @pagination-change-page="getData">
                    <span slot="prev-nav" class="prev-nav ir_pm">prev</span>
                    <span slot="next-nav" class="next-nav ir_pm">next</span>
                </pagination>
            </nav>
        </div>
    </div>
</template>

<script>
import LectureList from '@/components/mypage/lecture/LectureList.vue';
import LectureOrder from '@/components/mypage/lecture/LectureOrder.vue';

// api
import Mypage from '@/api/mypage/Mypage.js';

export default {
    name: 'MypageLecture',
    components: {
        'lecture-list': LectureList,
        'lecture-order': LectureOrder,
    },
    data() {
        return {
            list: {},
            order: 'newest',
            page: 1
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        handleSetOrder(order) {
            this.order = order;
            this.getData()
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
    }
}
</script>

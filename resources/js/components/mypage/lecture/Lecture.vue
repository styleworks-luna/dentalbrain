<template>
    <div>
        <lecture-order @setOrder="handleSetOrder"></lecture-order>
        <lecture-list :list="list.data"></lecture-list>
    </div>
</template>

<script>
import LectureList from '@/components/mypage/lecture/LectureList.vue';
import LectureOrder from '@/components/mypage/lecture/LectureOrder.vue';

// api
import Mypage from '@/api/mypage/Mypage.js'

export default {
    name: 'MypageLecture',
    components: {
        'lecture-list': LectureList,
        'lecture-order': LectureOrder,
    },
    data() {
        return {
            list: {},
            order_by: 'newest',
            page: 1
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        handleSetOrder(order_by) {
            this.order_by = order_by;
            this.getData()
        },
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                per_page: this.per_page,
                order_by: this.order_by,
                page: page
            };

            Mypage.getData(params).then(res => {
                this.list = res.data;
            }).catch(err => {
                this.list = [];
            });
        },
    }
}
</script>

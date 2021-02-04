<template>
    <section class="lecture">
        <lecture-navigation @setMenu="handleSetMenu"></lecture-navigation>
        <lecture-order v-if="is_pagination" @setOrder="handleSetOrder"></lecture-order>
        <lecture-list :list="list.data"></lecture-list>

        <div class="paging-wrap" v-if="is_pagination">
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
import LectureNavigation from '@/components/lecture/LectureNavigation.vue';
import LectureList from '@/components/lecture/LectureList.vue';
import LectureOrder from '@/components/lecture/LectureOrder.vue';

// api
import Lecture from '@/api/lecture/Lecture.js'

export default {
    name: 'Lecture',
    components: {
        'lecture-navigation': LectureNavigation,
        'lecture-list': LectureList,
        'lecture-order': LectureOrder,
    },
    props: {
        'is_pagination': Boolean,
        'per_page': Number,
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
                category_id: this.category_id,
                per_page: this.per_page,
                order_by: this.order_by,
                page: page
            };

            Lecture.getData(params).then(res => {
                console.log(res);
                this.list = res.data;
            }).catch(err => {
                this.list = [];
            });
        },
    }
}
</script>

<template>
    <section class="lecture">
        <lecture-navigation @setMenu="handleSetMenu"></lecture-navigation>
        <lecture-order></lecture-order>
        <lecture-list :list="list"></lecture-list>


        <div class="paging-wrap text-center" v-if="this.page>=2">
        <nav class="d-inline-block">
            <pagination :data="list" @pagination-change-page="getData" class="mb-0">
                <span slot="prev-nav">‹</span>
                <span slot="next-nav">›</span>
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
    data() {
        return {
            category_id: 1,
            list: [],
            per_page: 12,
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
        getData(page=this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                category_id : this.category_id,
                per_page: this.per_page,
                page: page
            };

            Lecture.getData(params).then(res => {
                this.list = res.data.data;
            }).catch(err => {
                this.list = [];
            });
        },
    }
}
</script>

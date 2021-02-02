<template>
    <div class="lecture-contents">
        <ul>
            <li class="lecture-card" v-for="lecture in lectures">
                <a href="">
                    <img :src="lecture.thumbnail.url" alt="">
                    <div class="lecture-description">
                        <div class="lecture-description-sub">
                            <p class="lecture-type">{{ lecture.major_category_name }}・{{ lecture.minor_category_name }}</p>
                            <p class="lecture-time">{{ lecture.running_time }}</p>
                        </div>
                        <a href="" class="lecture-name">{{ lecture.title }}</a>
                        <p class="lecture-price" v-if="lecture.ticket.is_free == 0">{{ lecture.ticket.price }}</p>
                        <p class="lecture-price" v-else>무료</p>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
import Lecture from '@/api/lecture/Lecture.js'

export default {
    name: 'LectureList',
    data() {
        return {
            category_id: 1,
            lectures: [],
        }
    },
    created() {

    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            Lecture.getData(this.category_id).then(res => {
                console.log(res);
                this.lectures = res.data;
            }).catch(err => {
                this.lectures = [];
            });
        },
    }
}

</script>

<style>

</style>

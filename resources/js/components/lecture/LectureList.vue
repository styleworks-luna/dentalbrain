<template>
    <div class="lecture-contents">
        <ul>
            <li class="lecture-card" v-for="lecture in lectures" :key="lecture.id">
                <a :href="'/lectures/' + lecture.id">
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
export default {
    name: 'LectureList',
    props: {
        'list' : Array
    },
    data() {
        return {
            lectures: [],
        }
    },
    watch: {
        list() {
            this.lectures = this.list;
        }
    }
}

</script>

<style>

</style>

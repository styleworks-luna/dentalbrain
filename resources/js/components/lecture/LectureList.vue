<template>
    <div class="lecture-contents">
        <ul>
            <li class="lecture-card" v-for="lecture in lectures" :key="lecture.id">
                <a :href="'/lectures/' + lecture.id">
                    <img :src="lecture.thumbnail.url" alt="">
                    <div class="lecture-description">
                        <div class="lecture-description-sub">
                            <p class="lecture-type">{{ lecture.major_category_name }}・{{ lecture.minor_category_name }}</p>
                            <p class="lecture-time" v-if="lecture.place == null">{{ lecture.running_time }}</p>
                            <p class="lecture-time"
                               v-else-if="lecture.place != null && lecture.place.started_at != lecture.place.ended_at">
                                {{ Helper.dateFormatDMW(lecture.place.started_at) }} ~ {{ Helper.dateFormatDMW(lecture.place.ended_at) }}
                            </p>
                            <p class="lecture-time"
                               v-else-if="lecture.place != null && Helper.dateFormatYDM(lecture.place.started_at) == Helper.dateFormatYDM(lecture.place.ended_at)">
                                {{ Helper.dateFormatDMW(lecture.place.started_at) }}
                            </p>
                        </div>
                        <p class="lecture-name">{{ lecture.title }}</p>
                        <p class="lecture-price" v-if="lecture.ticket.is_free == 0">{{ Helper.numberWithCommas(lecture.ticket.price) }}원</p>
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

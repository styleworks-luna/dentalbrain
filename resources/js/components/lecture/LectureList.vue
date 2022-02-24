<template>
    <div class="lecture-contents">
        <ul>
            <li class="lecture-card" v-for="lecture in lectures" :key="lecture.id">
                <a :href="'/lectures/' + lecture.id">
                    <img :src="lecture.thumbnail.url" alt="">
                    <div class="lecture-description">
                        <div class="lecture-description-sub">
                            <span class="lecture-type">{{lecture.minor_category_name}}</span>
                            <p class="lecture-date">수강기간 10일</p>
                            <p class="lecture-time" v-if="lecture.place == null">{{ lecture.running_time }}</p>
                            <p class="lecture-time"
                               v-else-if="lecture.place != null && !Helper.dateCompare(lecture.place.started_at, lecture.place.ended_at)">
                                {{ Helper.dateFormatDMW(lecture.place.started_at) }} ~
                                {{ Helper.dateFormatDMW(lecture.place.ended_at) }}
                            </p>
                            <p class="lecture-time"
                               v-else-if="lecture.place != null && Helper.dateCompare(lecture.place.started_at, lecture.place.ended_at)">
                                {{ Helper.dateFormatDMW(lecture.place.started_at) }}
                            </p>
                        </div>
                        <p class="lecture-name">{{ lecture.title }}</p>
                        <div class="lecture-all-price">
                            <span class="lecture-sale" v-if="lecture.is_free == 0">{{"30%"}}</span>
                            <span class="lecture-price" v-if="lecture.is_free == 0">
                            {{ Helper.numberWithCommas(lecture.price) }}원</span>
                            <span class="lecture-ogprice" v-if="lecture.is_free == 0">{{"500,000"}}</span>
                            <p class="lecture-price" v-else>무료</p>
                        </div>

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
        'list': Array
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

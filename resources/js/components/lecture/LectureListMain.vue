<template>
    <div class="lecture-contents">
        <ul>
            <li class="lecture-card" v-for="lecture in lectures" :key="lecture.id">
                <a :href="'/lectures/' + lecture.id">
                    <div class="lecture-image-box">
                        <img :src="lecture.thumbnail.url" alt="">
                        <template v-if="lecture.completion_id && lecture.qualification_id">
                            <div class="certificate-mark">수료/자격증</div>
                        </template>
                        <template v-else-if="lecture.completion_id">
                            <div class="certificate-mark">수료증</div>
                        </template>
                        <template v-else-if="lecture.qualification_id">
                            <div class="certificate-mark">자격증</div>
                        </template>
                    </div>
                    <div class="lecture-description">
                        <div class="lecture-description-sub">
                            <span class="lecture-type">{{ lecture.minor_category_name }}</span>
                            <p class="lecture-date" v-if="lecture.minor_category_name!='스토어'">
                                <template v-if="lecture.is_online==true">수강기간 {{ lecture.term }}일</template>
                            </p>
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
                        <div v-if="!isMobile()" class="lecture-all-price">
                            <template v-if="lecture.is_free == 0 && lecture.discount_rate != 0">
                                <span class="lecture-sale">{{ lecture.discount_rate }}%</span>
                                <p class="lecture-price">{{ Helper.numberWithCommas(lecture.discounted_price) }}원</p>
                                <span class="lecture-ogprice">{{ Helper.numberWithCommas(lecture.price) }}원</span>
                            </template>
                            <p class="lecture-price" v-if="lecture.is_free == 0 && lecture.discount_rate == 0">
                                {{ Helper.numberWithCommas(lecture.price) }}원</p>
                            <p class="lecture-price" v-if="lecture.is_free != 0">무료</p>
                        </div>

                        <div v-else class="lecture-all-price">
                            <template v-if="lecture.is_free == 0 && lecture.discount_rate != 0">
                                <span class="lecture-sale">{{ lecture.discount_rate }}%</span>
                                <span style="padding-bottom: 4px" class="lecture-ogprice">{{ Helper.numberWithCommas(lecture.price) }}원</span>
                                <p class="lecture-price">
                                    {{ Helper.numberWithCommas(lecture.discounted_price) }}원</p>
                            </template>
                            <p style="padding-top: 5vw" class="lecture-price" v-if="lecture.is_free == 0 && lecture.discount_rate == 0">
                                {{ Helper.numberWithCommas(lecture.price) }}원</p>
                            <p style="padding-top: 5vw"class="lecture-price" v-if="lecture.is_free != 0">무료</p>
                        </div>

                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'LectureListMain',
    methods: {
        isMobile() {
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                return true
            } else {
                return false
            }
        }
    },
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

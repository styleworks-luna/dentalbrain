<template>
    <div class="swiper-wrapper">
        <ul class="swiper-slide" v-for="lecture in lectures">
            <li class="lecture-card" :key="lectures.id">
                <a :href="'/lectures/' + lecture.program_id">
                    <img :src="lecture.program.thumbnail.url" alt="">
                    <div class="lecture-description">
                        <div class="lecture-description-sub">
                            <span class="lecture-type">{{lecture.program.minor_category_name}}</span>
                            <p class="lecture-date">수강기간 10일</p>
                            <p class="lecture-time">{{ lecture.program.running_time }}</p>
                        </div>
                        <p class="lecture-name">{{ lecture.program.title }}</p>
                        <div v-if="!isMobile()" class="lecture-all-price">
                            <template v-if="lecture.program.price != 0 && lecture.program.discount_rate != 0">
                                <span class="lecture-sale">{{ lecture.discount_rate }}%</span>
                                <span class="lecture-price">
                                    {{ Helper.numberWithCommas(lecture.program.discounted_price) }}원</span>
                                <span class="lecture-ogprice">{{ Helper.numberWithCommas(lecture.program.price) }}원</span>
                            </template>
                            <p class="lecture-price" v-if="lecture.is_free == 0 && lecture.discount_rate == 0">
                                {{ Helper.numberWithCommas(lecture.program.discounted_price) }}원</p>
                            <p class="lecture-price" v-if="lecture.program.price == 0">무료</p>
                        </div>
                        <div v-else class="lecture-all-price">
                            <template v-if="lecture.program.price != 0 && lecture.program.discount_rate != 0">
                                <span class="lecture-sale">{{ lecture.discount_rate }}%</span>
                                <span style="padding-bottom: 4px" class="lecture-ogprice">
                                    {{ Helper.numberWithCommas(lecture.program.price) }}원</span>
                                <p class="lecture-price">{{ Helper.numberWithCommas(lecture.program.discounted_price) }}원</p>
                            </template>
                            <p style="padding-top: 5vw" class="lecture-price" v-if="lecture.program.price != 0 && lecture.program.discount_rate == 0">
                                {{ Helper.numberWithCommas(lecture.price) }}원</p>
                            <p style="padding-top: 5vw" class="lecture-price" v-if="lecture.program.price == 0">무료</p>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';

// api
import Lecture from '@/api/lecture/Lecture.js'

export default {
    name: 'LectureBanner1',
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
    },
    mounted() {
        this.getBanner1();
    },
    methods: {
        isMobile() {
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                return true
            } else {
                return false
            }
        },
        getBanner1(){
            Lecture.getBanner1().then(res =>{
                this.lectures = res.data.banners;
            })
        }
    },

}

</script>

<style>

</style>

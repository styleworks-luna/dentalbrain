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
                            <span class="lecture-sale" v-if="lecture.program.price != 0">{{"30%"}}</span>
                            <span class="lecture-price" v-if="lecture.program.price != 0">
                                {{ Helper.numberWithCommas(lecture.program.price) }}원</span>
                            <span class="lecture-ogprice" v-if="lecture.program.price != 0">{{"500,000"}}</span>
                            <p class="lecture-price" v-else>무료</p>
                        </div>
                        <div v-else class="lecture-all-price">
                            <span class="lecture-sale" v-if="lecture.program.price != 0">{{"30%"}}</span>
                            <span style="padding-bottom: 4px" class="lecture-ogprice" v-if="lecture.program.price != 0">{{"500,000"}}</span>
                            <p class="lecture-price" v-if="lecture.program.price != 0">{{ Helper.numberWithCommas(lecture.program.price) }}원</p>
                            <p style="padding-top: 5vw" class="lecture-price" v-else>무료</p>
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
    name: 'LectureBanner2',
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
        this.getBanner2();
    },
    methods: {
        isMobile() {
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                return true
            } else {
                return false
            }
        },
        getBanner2(){
            Lecture.getBanner2().then(res =>{
                this.lectures = res.data.banners;
            })
        }
    },

}

</script>

<style>

</style>

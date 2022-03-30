<template>
    <div class="swiper-wrapper">
        <ul class="swiper-slide" v-for="banner in banners">
            <li class="lecture-card" :key="banner.id">
                <a :href="'/banner-redirect/' + banner.id">
                    <img :src="banner.program.thumbnail.url" alt="">
                    <div class="lecture-description">
                        <div class="lecture-description-sub">
                            <span class="lecture-type">{{banner.program.minor_category_name}}</span>
                            <p class="lecture-date" v-if="banner.program.minor_category_name!='스토어'">수강기간 {{ banner.program.term }}일</p>
                            <p class="lecture-time">{{ banner.program.running_time }}</p>
                        </div>
                        <p class="lecture-name">{{ banner.program.title }}</p>
                        <div v-if="!isMobile()" class="lecture-all-price">
                            <template v-if="banner.program.price != 0 && banner.program.discount_rate != 0">
                                <span class="lecture-sale">{{ banner.program.discount_rate }}%</span>
                                <span class="lecture-price">
                                    {{ Helper.numberWithCommas(banner.program.discounted_price) }}원</span>
                                <span class="lecture-ogprice">{{ Helper.numberWithCommas(banner.program.price) }}원</span>
                            </template>
                            <p class="lecture-price" v-if="banner.program.price != 0 && banner.program.discount_rate == 0">
                                {{ Helper.numberWithCommas(banner.program.price) }}원</p>
                            <p class="lecture-price" v-if="banner.program.price == 0">무료</p>
                        </div>
                        <div v-else class="lecture-all-price">
                            <template v-if="banner.program.price != 0 && banner.program.discount_rate != 0">
                                <span class="lecture-sale">{{ banner.program.discount_rate }}%</span>
                                <span style="padding-bottom: 4px" class="lecture-ogprice">
                                    {{ Helper.numberWithCommas(banner.program.price) }}원</span>
                                <p class="lecture-price">{{ Helper.numberWithCommas(banner.program.discounted_price) }}원</p>
                            </template>
                            <p style="padding-top: 5vw" class="lecture-price" v-if="banner.program.price != 0 && banner.program.discount_rate == 0">
                                {{ Helper.numberWithCommas(banner.program.price) }}원</p>
                            <p style="padding-top: 5vw" class="lecture-price" v-if="banner.program.price == 0">무료</p>
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
            banners: [],
        }
    },
    watch: {
        list() {
            this.banners = this.list;
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
                this.banners = res.data.banners;
            })
        }
    },

}

</script>

<style>

</style>

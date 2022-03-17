<template>
    <div class="swiper-wrapper">
        <ul class="swiper-slide" v-for="lecture in lectures">
            <li class="lecture-card" :key="lectures.id">
                <a :href="'/lectures/' + lecture.program_id">
                    <img :src="lecture.program.thumbnail.url" alt="">
                    <div class="lecture-description">
                        <div class="lecture-description-sub">
                            <span class="lecture-type">{{lecture.minor_category_name}}</span>
                            <p class="lecture-date">수강기간 10일</p>
                            <p class="lecture-time">{{ lecture.running_time }}</p>
                        </div>
                        <p class="lecture-name">{{ lecture.title }}</p>
                        <div v-if="!isMobile()" class="lecture-all-price">
                            <span class="lecture-sale">{{"30%"}}</span>
                            <span class="lecture-price">{{ lecture.price }}원</span>
                            <span class="lecture-ogprice">{{"500,000"}}</span>
                        </div>
                        <div v-else class="lecture-all-price">
                            <span class="lecture-sale">{{"30%"}}</span>
                            <span style="padding-bottom: 4px" class="lecture-ogprice">{{"500,000"}}</span>
                            <p class="lecture-price">{{ lecture.price }}원</p>
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
            lectures: [{

            }],
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
        getBanner1(){
            Lecture.getBanner1().then(res =>{
                this.lectures = res.data.banners;
            })
        },
        isMobile() {
            if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                return true
            } else {
                return false
            }
        },

    },

}

</script>

<style>

</style>

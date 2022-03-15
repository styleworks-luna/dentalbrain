<template>
    <div class="swiper-wrapper">
        <ul class="swiper-slide" v-for="lecture in lectures">
            <li class="lecture-card" :key="lectures.id">
                <a :href="'/lectures/' + lecture.id">
                    <img :src="lecture.url" alt="">
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
export default {
    name: 'LectureBanner1',
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
            lectures: [
                {
                    id: 1,
                    url: "http://dbv2020.onoffmix.test/storage/program/12/thumbnail/123.jpg",
                    minor_category_name: "예방",
                    running_time: "수강기간 10일",
                    title: "test",
                    price: "123,123",


                },
                {
                    id: 2,
                    url: "http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG",
                    minor_category_name: "예방",
                    running_time: "수강기간 10일",
                    title: "슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉슈슉",
                    price: "123,123",
                },
                {
                    id: 3,
                    url: "http://dbv2020.onoffmix.test/storage/program/12/thumbnail/123.jpg",
                    minor_category_name: "예방",
                    running_time: "수강기간 10일",
                    title: "test",
                    price: "123,123",


                },
                {
                    id: 4,
                    url: "http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG",
                    minor_category_name: "예방",
                    running_time: "수강기간 10일",
                    title: "test",
                    price: "123,123",
                },
                {
                    id: 5,
                    url: "http://dbv2020.onoffmix.test/storage/program/12/thumbnail/123.jpg",
                    minor_category_name: "예방",
                    running_time: "수강기간 10일",
                    title: "test",
                    price: "123,123",


                },
                {
                    id: 6,
                    url: "http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG",
                    minor_category_name: "예방",
                    running_time: "수강기간 10일",
                    title: "test",
                    price: "123,123",
                },
                {
                    id: 7,
                    url: "http://dbv2020.onoffmix.test/storage/program/12/thumbnail/123.jpg",
                    minor_category_name: "예방",
                    running_time: "수강기간 10일",
                    title: "test",
                    price: "123,123",


                },
                {
                    id: 8,
                    url: "http://dbv2020.onoffmix.test/storage/program/11/thumbnail/dasd.PNG",
                    minor_category_name: "예방",
                    running_time: "수강기간 10일",
                    title: "test",
                    price: "123,123",
                },
            ],
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

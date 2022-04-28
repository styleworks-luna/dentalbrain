<template>
    <section class="mypage-albatalk">
        <template v-if="!mobile">
            <albatalk-navigation :myRecruitList="myRecruitList" :albaTalkList="albaTalkList" :is_offer="is_offer"></albatalk-navigation>
            <ul v-if="is_offer" class="mypage-albatalk-navigation">
                <li class="navigation-list active">
                    <a href="/account/offer">신청내역</a>
                </li>
                <li class="navigation-list">
                    <a href="/account/resume">이력서 정보</a>
                </li>
            </ul>
        </template>
        <template v-if="is_offer">
            <albatalk-offer-list :listData=myRecruitList :mobile="mobile"></albatalk-offer-list>
        </template>
        <template v-else>
            <albatalk-list :listData=albaTalkList :mobile="mobile"></albatalk-list>
        </template>
    </section>
</template>

<script>
import AlbaTalkList from '@/components/mypage/albatalk/AlbaTalkList.vue';
import AlbaTalkOfferList from '@/components/mypage/albatalk/AlbaTalkOfferList.vue';
import AlbaTalkNavigation from '@/components/mypage/albatalk/AlbaTalkNavigation.vue';

import Mypage from '@/api/mypage/Mypage.js';

export default {
    name: "AlbaTalk",
    components: {
        'albatalk-list': AlbaTalkList,
        'albatalk-offer-list': AlbaTalkOfferList,
        'albatalk-navigation': AlbaTalkNavigation,
    },
    props: {
        'is_offer': Boolean,
        "mobile": Boolean,
    },
    data() {
        return {
            albaTalkList: [],
            myRecruitList: [],
        }
    },
    mounted() {
        this.getAlbaTalk();
        this.getMyRecruit();
    },
    methods: {
      getAlbaTalk() {
          Mypage.getAlbaTalk().then(res => {
              this.albaTalkList = res.data.recruits;
          }).catch(err => {
              this.albaTalkList = [];
          });
      },
      getMyRecruit() {
          Mypage.getMyRecruit().then(res => {
              this.myRecruitList = res.data;
          }).catch(err => {
              this.myRecruitList = [];
          });
      },
    }
}
</script>

<style scoped>

</style>

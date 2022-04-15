<template>
    <section class="mypage-albatalk">
        <template v-if="is_offer">
            <albatalk-offer-list :mobile="mobile"></albatalk-offer-list>
        </template>
        <template v-else>
            <albatalk-list :listData=albaTalkList :mobile="mobile"></albatalk-list>
        </template>
    </section>
</template>

<script>
import AlbaTalkList from '@/components/mypage/albatalk/AlbaTalkList.vue';
import AlbaTalkOfferList from '@/components/mypage/albatalk/AlbaTalkOfferList.vue';

import Mypage from '@/api/mypage/Mypage.js';

export default {
    name: "AlbaTalk",
    components: {
        'albatalk-list': AlbaTalkList,
        'albatalk-offer-list': AlbaTalkOfferList,
    },
    props: {
        'is_offer': Boolean,
        "mobile": Boolean,
    },
    data() {
        return {
            albaTalkList: [],
        }
    },
    mounted() {
        this.getAlbaTalk();
    },
    methods: {
      getAlbaTalk() {
          Mypage.getAlbaTalk().then(res => {
              this.albaTalkList = res.data.$recruits;
          }).catch(err => {
              this.albaTalkList = [];
          });
      }
    }
}
</script>

<style scoped>

</style>

<template>
    <div class="albatalk-contents" :class="mobile ? 'm-row': ''">
        <ul :class="lists.length > 0 ? 'albatalk-content-list' : ''">
            <li class="albatalk-content-item" v-for="list in lists" :key="list.id">
                <a :href="`/albatalk/recruit/${list.recruit_id}`" class="albatalk-card">
                    <img :src='list.recruit.file ? list.recruit.file.url : ""'>
                    <div class="albatalk-information">
                        <p class="albatalk-name">{{ list.recruit.company_name }}</p>
                        <div class="albatalk-description">
                            <p class="albatalk-place">{{ list.recruit.sido }} {{ list.recruit.gugun }}</p>
                            <p v-if="(list.recruit.ended_at==null)" class="albatalk-date">채용시까지</p>
                            <p v-else class="albatalk-date">~ {{ Helper.dateFormatDMW(list.recruit.ended_at) }}</p>
                        </div>
                    </div>
                </a>
                <div class="albatalk-additional-information">
                    <p v-if="(Helper.dateCompareWithNow(list.recruit.ended_at) < 0) && (list.recruit.ended_at!=null)"
                       class="refuse-state">모집마감</p>
                    <div class="btn-wrap" v-else>
                        <form :action="`/albatalk/recruit/${list.recruit.id}/cancel`" method="post">
                            <input type="hidden" name="_token" :value="token">
                            <button class="btn-cancel">제출취소</button>
                        </form>
                    </div>
                </div>
            </li>
            <li class="none" v-if="lists.length <= 0">
                <p>신청한 구직 내역이 없습니다.</p>
                <div class="btn-wrap">
                    <a v-if="mobile == false" href="/albatalk" class="btn-go-offer">구직 신청하러가기</a>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkOfferList",
    props: {
        listData: Array,
        mobile: Boolean,
    },
    computed: {
      token() {
          return document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    },
    data() {
        return {
            lists: [],
        }
    },
    watch: {
        listData() {
            this.lists = this.listData
        }
    },
}
</script>

<style scoped>

</style>

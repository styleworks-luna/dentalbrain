<template>
    <div class="albatalk-contents" :class="mobile ? 'm-row': ''">
        <ul :class="lists.length > 0 ? 'albatalk-content-list' : ''">
            <li class="albatalk-content-item" v-for="list in lists" :key="list.id">
                <a :href="`/albatalk/recruit/${list.id}`" class="albatalk-card">
                    <img :src='list.file ? list.file.url : ""'>
                    <div class="albatalk-information">
                        <p class="albatalk-name">{{ list.company_name }}</p>
                        <div class="albatalk-description">
                            <p class="albatalk-place">{{ list.sido }} {{ list.gugun }}</p>
                            <p class="albatalk-date">~ {{ Helper.dateFormatDMW(list.ended_at) }}</p>
                        </div>
                    </div>
                </a>
                <div class="albatalk-additional-information">
                    <p v-if="(list.remain_day>0)" class="albatalk-period">게재 기간 : {{ list.remain_day }}일 남음</p>
                    <p v-else class="albatalk-period">게재 기간 : 종료</p>
                    <p class="albatalk-state">이력서 제출 현황 : <em>{{ list.state }}</em>건</p>
                    <div v-if="(mobile == false)" class="btn-wrap">
                        <a v-if="(list.remain_day>0)" :href="`/albatalk/recruit/${list.id}/edit`" class="btn-edit">수정하기</a>
                        <a v-else :href="`/albatalk/recruit/${list.id}/duplicate`" class="btn-edit">복사하기</a>
                    </div>
                </div>
            </li>
            <li class="none" v-if="lists.length <= 0">
                <p>등록한 구인정보가 없습니다.</p>
                <div class="btn-wrap">
                    <a v-if="mobile == false" href="" class="btn-go-recruit">구인 등록하기</a>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkList",
    props: {
        listData: Array,
        mobile: Boolean,
    },
    data() {
        return {
            lists: [],
        }
    },
    watch: {
        listData(){
            this.lists = this.listData
        }
    }
}
</script>

<style scoped>

</style>

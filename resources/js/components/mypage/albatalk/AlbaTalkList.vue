<template>
    <div class="albatalk-contents" :class="mobile ? 'm-row': ''">
        <ul :class="lists.length > 0 ? 'albatalk-content-list' : ''">
            <li class="albatalk-content-item" v-for="list in lists" :key="list.id">
                <a href="" class="albatalk-card">
                    <img src="/images/dummy/test2.jpg">
                    <div class="albatalk-information">
                        <p class="albatalk-name">{{ list.title }}</p>
                        <div class="albatalk-description">
                            <p class="albatalk-place">{{ list.location }}</p>
                            <p class="albatalk-date">{{ list.date }}</p>
                        </div>
                    </div>
                </a>
                <div class="albatalk-additional-information">
                    <p class="albatalk-period">게재 기간 : {{ list.period }}일 남음</p>
                    <p class="albatalk-state">이력서 제출 현황 : <em>{{ list.state }}</em>건</p>
                    <div v-if="mobile == false" class="btn-wrap">
                        <button class="btn-edit">수정하기</button>
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
        mobile: Boolean,
    },
    data() {
        return {
            lists: [
            ]
        }
    }
}
</script>

<style scoped>

</style>

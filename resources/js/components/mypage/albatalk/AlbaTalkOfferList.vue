<template>
    <div class="albatalk-contents" :class="mobile ? 'm-row': ''">
        <ul  :class="lists.length > 0 ? 'albatalk-content-list' : ''">
            <li class="albatalk-content-item" v-for="list in lists" :key="list.id">
                <a class="albatalk-card" href="">
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
                    <p class="refuse-state" v-if="list.state == '1'">모집마감</p>
                    <div class="btn-wrap" v-else>
                    <button class="btn-cancel">제출취소</button>
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
        mobile: Boolean,
    },
    data() {
        return {
            lists: [
                {
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '0',
                },
                {
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '1',
                },
                {
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '0',
                },
                {
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '1',
                },
                {
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '0',
                },
                {
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '1',
                },
                {
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '0',
                },
                {
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '1',
                },
            ]
        }
    }
}
</script>

<style scoped>

</style>

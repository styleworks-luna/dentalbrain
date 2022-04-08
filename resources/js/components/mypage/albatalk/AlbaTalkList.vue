<template>
    <div class="albatalk-contents">
        <ul :class="lists.length > 0 ? 'albatalk-content-list' : ''">
            <li class="albatalk-card" v-for="list in lists" :key="list.id">
                <a href="">
                    <img src="/images/dummy/test2.jpg">
                    <div class="albatalk-information">
                        <p class="albatalk-name">{{ list.title }}</p>
                        <div class="albatalk-description">
                            <p class="albatalk-place">{{ list.location }}</p>
                            <p class="albatalk-date">{{ list.date }}</p>
                        </div>
                    </div>
                </a>
                <div class="albatalk-bottom">
                    <div class="albatalk-period">게재 기간 : {{ list.period }}일 남음</div>
                    <div class="albatalk-state">이력서 제출 현황 : <strong>{{ list.state }}</strong>건</div>
                    <button class="btn">수정하기</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkList",
    data() {
        return {
            lists: [
                {
                    key: 1,
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '0',
                },
                {
                    key: 2,
                    title: "브레인스펙치과",
                    location: "경기도 하남시",
                    date: "채용시까지",
                    period: '7',
                    state: '2',
                },
            ]
        }
    }
}
</script>

<style scoped>

</style>

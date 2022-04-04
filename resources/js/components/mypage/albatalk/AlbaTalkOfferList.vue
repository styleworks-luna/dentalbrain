<template>
    <div class="albatalk-contents">
        <ul>
            <li v-for="list in list" :key="list.id">
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
                <div class="albatalk-bottom">
                    <button class="btn">제출취소</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkOfferList",
    data() {
        return {
            list: [
                {
                    key: 1,
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지",
                    period: '7',
                    state: '0',
                },
            ]
        }
    }
}
</script>

<style scoped>

</style>

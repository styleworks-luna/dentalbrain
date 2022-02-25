<template>
    <div class="alba-talk-list">
        <ul>
            <li v-for="list in list" :key="list.id">
                <a href="">
                    <img src="/images/dummy/test2.jpg">
                        <div>{{ list.title }}</div>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkList",
    data () {
        return {
            list: [
                {
                    key: 1,
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지"
                },
                {
                    key: 2,
                    title: "브레인스펙치과",
                    location: "경기도 하남시",
                    date: "채용시까지"
                },
                {
                    key: 3,
                    title: "서울 덴탈브레인 이가 튼튼 반짝 반",
                    location: "서울 서초구",
                    date: "~3/22(화)"
                },
                {
                    key: 4,
                    title: "덴탈브레인 치과의원",
                    location: "서울 강서구",
                    date: "채용시까지"
                }
            ]
        }
    }
}
</script>

<style scoped>

</style>

<template>
    <div class="content-title">
        <template v-if="is_offer">
            <h2>구직정보</h2>
            <a v-if="myRecruitList.length" href="/albatalk">구직 신청하러 가기</a>
        </template>

        <template v-else>
            <h2>구인정보</h2>
            <a v-if="albaTalkList.length" href="/albatalk/recruit">구인 등록하기</a>
        </template>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkNavigation",
    props: {
        myRecruitList: Array,
        albaTalkList: Array,
        is_offer: Boolean,
    }
}
</script>

<style scoped>

</style>

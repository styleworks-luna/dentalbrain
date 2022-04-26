<template>
    <div class="content-title">
        <template v-if="is_offer">
            <h2>구직정보</h2>
            <a v-if="recruitlist.length" href="/albatalk/recruit">구직 등록하기</a>
        </template>

        <template v-else>
            <h2>구인정보</h2>
            <a v-if="albatalklist.length" href="/albatalk/recruit">구직 등록하기</a>
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
    },
    data() {
        return {
            recruitlist: [],
            albatalklist: [],
        }
    },
    watch: {
        myRecruitList() {
            this.recruitlist = this.myRecruitList
        },
        albaTalkList(){
            this.albatalklist = this.albaTalkList
        }
    },
}
</script>

<style scoped>

</style>

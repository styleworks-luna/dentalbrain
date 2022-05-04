<template>
    <div class="albatalk-contents" :class="mobile ? 'm-row': ''">
        <ul :class="albatalks.length > 0 ? 'albatalk-content-list' : ''">
            <li class="albatalk-card" v-for="list in albatalks" :key="list.id">
                <a :href="'/albatalk/recruit/' + list.id">
                    <img :src='list.file ? list.file.url :""'>
                    <div class="albatalk-information">
                        <p class="albatalk-name">{{ list.company_name }}</p>
                        <div class="albatalk-description">
                            <p class="albatalk-place">{{ list.sido }} {{ list.gugun }}</p>
                            <p v-if="(list.expired_at==null)" class="albatalk-date">채용시까지</p>
                            <p v-else class="albatalk-date">~ {{ Helper.dateFormatDMW(list.expired_at) }}</p>
                        </div>
                    </div>
                </a>
            </li>
            <li class="none" v-if="albatalks.length <= 0">
                <p>등록 된 구인 정보가 없습니다.</p>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkList",
    props: {
        mobile: Boolean,
        lists: Array
    },
    data() {
        return {
            albatalks: [],
        }
    },
    watch: {
        lists() {
            this.albatalks = this.lists;
        }
    }
}
</script>

<style scoped>

</style>

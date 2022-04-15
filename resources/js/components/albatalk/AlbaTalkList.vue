<template>
    <div class="albatalk-contents" :class="mobile ? 'm-row': ''">
        <ul :class="albatalks.length > 0 ? 'albatalk-content-list' : ''">
            <li class="albatalk-card" v-for="item in albatalks" :key="item.id">
                <a :href="`/albatalk/recruit/${item.id}`">
                    <img :src="item.file">
                    <div class="albatalk-information">
                        <p class="albatalk-name">{{ item.company_name }}</p>
                        <div class="albatalk-description">
                            <p class="albatalk-place">{{ item.sido }} {{ item.gugun }}</p>
                            <p class="albatalk-date">~ {{ Helper.dateFormatDMW(item.ended_at) }}</p>
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

<template>
    <section class="albatalk">
        <albatalk-navigation v-if="is_navigation"></albatalk-navigation>
        <albatalk-offer-list v-if="is_offer"></albatalk-offer-list>
        <albatalk-list v-else></albatalk-list>
    </section>
</template>

<script>
import AlbaTalkNavigation from '@/components/mypage/albatalk/AlbaTalkNavigation.vue';
import AlbaTalkList from '@/components/mypage/albatalk/AlbaTalkList.vue';
import AlbaTalkOfferList from '@/components/mypage/albatalk/AlbaTalkOfferList.vue';

export default {
    name: "AlbaTalk",
    components: {
        'albatalk-list': AlbaTalkList,
        'albatalk-offer-list': AlbaTalkOfferList,
        'albatalk-navigation': AlbaTalkNavigation,
    },
    props: {
        'is_offer': Boolean,
        'is_navigation': Boolean
    }
}
</script>

<style scoped>

</style>

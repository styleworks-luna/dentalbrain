<template>
    <section class="mypage-albatalk">
        <template v-if="is_offer">
            <albatalk-offer-list></albatalk-offer-list>
        </template>
        <albatalk-list v-else></albatalk-list>
    </section>
</template>

<script>
import AlbaTalkList from '@/components/mypage/albatalk/AlbaTalkList.vue';
import AlbaTalkOfferList from '@/components/mypage/albatalk/AlbaTalkOfferList.vue';

export default {
    name: "AlbaTalk",
    components: {
        'albatalk-list': AlbaTalkList,
        'albatalk-offer-list': AlbaTalkOfferList,
    },
    props: {
        'is_offer': Boolean
    }
}
</script>

<style scoped>

</style>

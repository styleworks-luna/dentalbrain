<template>
    <section class="albatalk">
        <albatalk-order></albatalk-order>
        <albatalk-navigation></albatalk-navigation>
        <albatalk-list></albatalk-list>
    </section>
</template>

<script>
import AlbaTalkList from '@/components/albatalk/AlbaTalkList.vue';
import AlbaTalkNavigation from '@/components/albatalk/AlbaTalkNavigation.vue';
import AlbaTalkOrder from '@/components/albatalk/AlbaTalkOrder.vue';

export default {
    name: "AlbaTalk",
    components: {
        'albatalk-list': AlbaTalkList,
        'albatalk-order': AlbaTalkOrder,
        'albatalk-navigation': AlbaTalkNavigation,
    },
    props: {
        'is_navigation': Boolean,
        'is_order': Boolean,
    }
}
</script>

<style scoped>

</style>

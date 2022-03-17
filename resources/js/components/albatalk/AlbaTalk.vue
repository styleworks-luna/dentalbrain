<template>
    <section class="albatalk">
        <albatalk-navigation></albatalk-navigation>
        <albatalk-list></albatalk-list>
    </section>
</template>

<script>
import AlbaTalkList from '@/components/albatalk/AlbaTalkList.vue';
import AlbaTalkNavigation from '@/components/albatalk/AlbaTalkNavigation.vue';

export default {
    name: "AlbaTalk",
    components: {
        'albatalk-list': AlbaTalkList,
        'albatalk-navigation': AlbaTalkNavigation,
    },
}
</script>

<style scoped>

</style>

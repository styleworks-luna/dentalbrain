<template>
    <section class="albatalk">
        <albatalk-list></albatalk-list>
    </section>
</template>

<script>
import AlbaTalkList from '@/components/albatalk/AlbaTalkList.vue';

export default {
    name: "AlbaTalk",
    components: {
        'albatalk-list': AlbaTalkList,
    },
}
</script>

<style scoped>

</style>

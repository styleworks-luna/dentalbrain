<template>
    <section class="albatalk">
        <albatalk-list></albatalk-list>
    </section>
</template>

<script>
import AlbaTalkList from '@/components/mypage/albatalk/AlbaTalkList.vue';

export default {
    name: "AlbaTalk",
    components: {
        'albatalk-list': AlbaTalkList,
    },
    props: {
    }
}
</script>

<style scoped>

</style>

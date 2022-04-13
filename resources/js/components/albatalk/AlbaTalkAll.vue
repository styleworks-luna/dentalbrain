<template>
    <section class="albatalk">
        <div class="albatalk-navigation">
            <albatalk-order :mobile="mobile"></albatalk-order>
            <albatalk-navigation :mobile="mobile"></albatalk-navigation>
        </div>
        <albatalk-list :mobile="mobile"></albatalk-list>
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
        "mobile": Boolean,
    }
}
</script>

<style scoped>

</style>

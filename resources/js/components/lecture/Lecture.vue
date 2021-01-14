<template>
    <section class="lecture">
        <lecture-navigation></lecture-navigation>
        <lecture-list></lecture-list>
    </section>
</template>

<script>
import LectureNavigation from '@/components/lecture/LectureNavigation.vue';
import LectureList from '@/components/lecture/LectureList.vue';

export default {
    name: 'lecture',
    components: {
        'lecture-navigation': LectureNavigation,
        'lecture-list': LectureList,
    }
}
</script>

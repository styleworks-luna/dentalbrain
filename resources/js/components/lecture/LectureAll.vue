<template>
    <section class="lecture">
        <lecture-navigation></lecture-navigation>
        <lecture-order></lecture-order>
        <lecture-list></lecture-list>
    </section>
</template>

<script>
import LectureNavigation from '@/components/lecture/LectureNavigation.vue';
import LectureList from '@/components/lecture/LectureList.vue';
import LectureOrder from '@/components/lecture/LectureOrder.vue';

export default {
    name: 'Lecture',
    components: {
        'lecture-navigation': LectureNavigation,
        'lecture-list': LectureList,
        'lecture-order': LectureOrder,
    }
}
</script>

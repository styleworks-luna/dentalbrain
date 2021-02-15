<template>
    <div>
    <lecture-order></lecture-order>
    <lecture-list></lecture-list>
    </div>
</template>

<script>
import LectureList from '@/components/mypage/lecture/LectureList.vue';
import LectureOrder from '@/components/mypage/lecture/LectureOrder.vue';

export default {
    name: 'MypageLecture',
    components: {
        'lecture-list': LectureList,
        'lecture-order': LectureOrder,
    },
}
</script>

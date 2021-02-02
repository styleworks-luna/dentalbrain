<template>
    <div class="lecture-menu">
        <ul>
            <li class="active-menu" @click="handleSetLectureMenu(1)">치과의사</li>
            <li @click="handleSetLectureMenu(2)">치과위생사</li>
            <li @click="handleSetLectureMenu(3)">치과조무사</li>
            <li @click="handleSetLectureMenu(5)">학생(민간자격증)</li>
            <li @click="handleSetLectureMenu(4)">치바시</li>
            <li @click="handleSetLectureMenu(6)">기타</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
      return {
      }
    },
    methods: {
        handleSetLectureMenu(value) {
            this.$emit('setMenu', value);
        }
    }
}

</script>

<style>

</style>

<template>
    <div class="lecture-menu">
        <ul>
            <li :class="{'active-menu': isActive == 1}" @click="handleSetLectureMenu(1,1)">치과의사</li>
            <li :class="{'active-menu': isActive == 2}" @click="handleSetLectureMenu(2,2)">치과위생사</li>
            <li :class="{'active-menu': isActive == 3}" @click="handleSetLectureMenu(3,3)">치과조무사</li>
            <li :class="{'active-menu': isActive == 4}" @click="handleSetLectureMenu(5,4)">학생(민간자격증)</li>
            <li :class="{'active-menu': isActive == 5}" @click="handleSetLectureMenu(4,5)">치바시</li>
            <li :class="{'active-menu': isActive == 6}" @click="handleSetLectureMenu(6,6)">기타</li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isActive: 1,
        }
    },
    methods: {
        handleSetLectureMenu(value, active) {
            this.isActive = active
            this.$emit('setMenu', value);
        }
    }
}

</script>

<style>

</style>

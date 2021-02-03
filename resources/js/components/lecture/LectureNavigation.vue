<template>
    <div class="lecture-menu">
        <ul>
            <li v-for="menu in menus" :class="{'active-menu': isActive == menu.id}" @click="handleSetLectureMenu(menu.id,menu.id)">{{ menu.name }}</li>
        </ul>
    </div>
</template>

<script>
//api
import Lecture from '@/api/lecture/Lecture.js'

export default {
    data() {
        return {
            isActive: 1,
            menus: []
        }
    },
    mounted() {
      this.getCategory();
    },
    methods: {
        handleSetLectureMenu(value, active) {
            this.isActive = active
            this.$emit('setMenu', value);
        },
        getCategory() {
            Lecture.getCategory().then(res => {
                this.menus = res.data;
            })
        }
    }
}

</script>

<style>

</style>

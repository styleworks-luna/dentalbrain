<template>
    <div class="lecture-menu">
        <ul>
            <li v-for="menu in menus" :id="menu.name" :class="{'active-menu': isActive == menu.id}" @click="handleSetLectureMenu(menu.id,menu.id)" v-html="replace(menu.name)"></li>
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
        },
        replace(data) {
            var replaceData = data.replace(' ', '<br>');
            return replaceData;
        }
    }
}

</script>

<style>

</style>

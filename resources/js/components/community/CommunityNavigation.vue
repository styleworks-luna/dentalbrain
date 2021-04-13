<template>
    <div class="community-menu">
        <ul>
            <li :class="{'active-menu': isActive == ''}" @click="handleSetMenu('')">전체</li>
            <li :class="{'active-menu': isActive == category.id}" v-for="category in categoryOption"
                @click="handleSetMenu(category.id)">{{ category.name }}
            </li>
        </ul>
    </div>
</template>

<script>
//api
import Community from '@/api/community/Community.js'

export default {
    data() {
        return {
            isActive: '',
            categoryOption: [],
        }
    },
    mounted() {
        this.getCategory();
    },
    methods: {
        handleSetMenu(active) {
            this.isActive = active;
            this.$emit('setMenu', active);
        },
        getCategory() {
            Community.getCategory().then(res => {
                this.categoryOption = res.data;
            });
        }
    }
}
</script>

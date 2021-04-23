<template>
    <div class="community-menu">

        <template v-if="mobile">
            <select id="community-menu-select" class="community-menu-select" v-model="isActive" @change="handleSetMenuSelect">
                <option value="">전체</option>
                <option v-for="category in categoryOption" :value="category.id">{{ category.name}}</option>
            </select>
        </template>

        <template v-else>
            <ul>
                <li :class="{'active-menu': isActive == ''}" @click="handleSetMenu('')">전체</li>
                <li :class="{'active-menu': isActive == category.id}" v-for="category in categoryOption"
                    @click="handleSetMenu(category.id)">{{ category.name }}
                </li>
            </ul>
        </template>
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
    props: {
        'mobile': Boolean,
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
        },
        handleSetMenuSelect() {
            console.log(this.isActive);
            this.$emit('setMenu', this.isActive);
        }
    }
}
</script>

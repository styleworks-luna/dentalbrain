<template>
    <div class="community-menu">

        <template v-if="mobile">

            <div class="community-menu-select">
                <input type="text" id="selected-category" readonly value="전체" @click="handleOption" @blur="handleOptionBlur">
                <ul id="custom-select" class="select-box">
                    <li :class="{'active-menu': isActive == ''}" @click="handleSetMenuSelect('', '전체')"> 전체</li>
                    <li :class="{'active-menu': isActive == category.id}" v-for="category in categoryOption" @click.self="handleSetMenuSelect(category.id, category.name)">{{ category.name }}</li>
                </ul>
            </div>
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
        handleSetMenuSelect(id, name) {
            document.getElementById('selected-category').value = name;
            this.isActive = id;
            this.$emit('setMenu', this.isActive);
            document.getElementById('custom-select').classList.remove('show');
            document.getElementById('selected-category').classList.remove('select-focus');
        },
        handleOption() {
            document.getElementById('custom-select').classList.toggle('show');
            document.getElementById('selected-category').classList.toggle('select-focus');
        },
        handleOptionBlur() {
            setTimeout(function() {
                document.getElementById('custom-select').classList.remove('show');
                document.getElementById('selected-category').classList.remove('select-focus');
                }, 1);
        }
    }
}
</script>

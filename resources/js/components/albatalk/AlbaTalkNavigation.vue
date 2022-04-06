<template>
    <div class="albatalk-menu">
        <div class="albatalk-menu-list-wrap">
            <p class="label">근무지역</p>
            <ul class="albatalk-menu-list">
                <li v-for="menuList in menuLists" :key="menuList.name">
                    <div class="input-wrap">
                        <input type="checkbox" :id="menuList.name" name="menuList.name">
                        <label for="menuList.name">{{ menuList.text }}</label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkNavigation",
    data() {
        return {
            menuLists: [
                {
                    name: 'all',
                    text: '전체'
                },
                {
                    name: 'seoul',
                    text: '서울'
                },
                {
                    name: 'gyeonggi',
                    text: '경기'
                },
                {
                    name: 'incheon',
                    text: '인천'
                },
                {
                    name: 'busan',
                    text: '부산'
                },
                {
                    name: 'daegu',
                    text: '대구'
                },
                {
                    name: 'daejeon',
                    text: '대전'
                },
                {
                    name: 'sejong',
                    text: '세종'
                },
                {
                    name: 'gwangju',
                    text: '광주'
                },
                {
                    name: 'ulsan',
                    text: '울산'
                },
                {
                    name: 'gangwon',
                    text: '강원'
                },
                {
                    name: 'gyeongnam',
                    text: '경남'
                },
                {
                    name: 'gyeongbuk',
                    text: '경북'
                },
                {
                    name: 'jeonam',
                    text: '전남'
                },
                {
                    name: 'jeonbuk',
                    text: '전북'
                },
                {
                    name: 'chungnam',
                    text: '충남'
                },
                {
                    name: 'chungbuk',
                    text: '충북'
                },
                {
                    name: 'jeju',
                    text: '제주'
                },
            ]
        }
    },
}
</script>

<style scoped>

</style>

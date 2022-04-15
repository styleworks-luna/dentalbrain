<template>
    <div class="albatalk-order">
        <template v-if="mobile">
        <div class="m-row">
            <ul class="order-list">
                <li>
                    <a href="" class="btn-menu" @click.prevent="show()">
                        <span>근무지역</span>
                        <span class="icon-filter"></span>
                    </a>
                </li>
                <li>
                    <select id="albatalk-order-select" class="albatalk-order-select">
                        <option value="newest" selected>등록일순</option>
                        <option value="newest">마감일순</option>
                    </select>
                </li>
            </ul>
        </div>
        </template>
        <template v-else>
            <h2>구인정보</h2>
            <ul>
                <li><a href="" class="active">등록일순</a></li>
                <li><a href="">마감일순</a></li>
            </ul>
        </template>
    </div>
</template>

<script>
export default {
    name: "AlbaTalkOrder",
    props: {
        'mobile': Boolean,
    },
    methods: {
        show(){
            document.getElementById("albatalk-menu").style.display='block';
        }
    }
}

</script>

<style>

</style>

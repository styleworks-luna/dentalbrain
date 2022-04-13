<template>
    <div class="albatalk-order">
        <template v-if="mobile">
            <a href="">근무지역</a>
            <select id="albatalk-order-select" class="albatalk-order-select">
                <option value="newest" selected>등록일순</option>
                <option value="newest">마감일순</option>
            </select>

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
}

</script>

<style>

</style>

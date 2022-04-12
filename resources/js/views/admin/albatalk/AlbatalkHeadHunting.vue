<template>
    <layout title="헤드 헌팅 주소 입력">
        <template v-slot:body>
            <div class="input-group w-50 mb-5">
                <input class="form-control"
                       type="text"
                       placeholder="https:// 로 시작하는 url 입력"
                       v-model="url">
                <span class="input-group-append">
                    <button class="btn btn-primary" type="submit" @click.prevent="edit">수정</button>
                </span>
            </div>
        </template>
    </layout>
</template>

<script>
export default {
    name: "AlbaTalkHeadHunting",
    data() {
        return {
            url: "",
        }
    },
    methods: {
        edit() {

        }
    }
}
</script>

<template>
    <layout title="헤드 헌팅 주소 입력">
        <template v-slot:body>
            <div class="input-group w-50 mb-5">
                <input class="form-control"
                       type="text"
                       placeholder="https:// 로 시작하는 url 입력"
                       v-model="url">
                <span class="input-group-append">
                    <button class="btn btn-primary" type="submit" @click.prevent="create">수정</button>
                </span>
            </div>
        </template>
    </layout>
</template>

<script>

// api
import HeadHunting from '@/api/admin/albatalk/HeadHunting.js';

export default {
    name: "AlbaTalkHeadHunting",
    data() {
        return {
            url: "",
        }
    },
    mounted() {
        this.init();
    },
    methods: {
        create() {
            HeadHunting.create(this.url).then(res => {
                alert('변경되었습니다.');
            })
        },
        init() {
            HeadHunting.getData().then(res => {
                this.url = res.data.url;
            });
        }
    }
}
</script>

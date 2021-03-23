<template>
    <layout title="커뮤니티" >
        <template v-slot:button>
            <router-link to="/admin/community/create"
                         class="btn btn-lg btn-info">
                새로 만들기
            </router-link>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="articles.data">
                <template v-slot:list="slotProps">
<!--                    <td>{{ slotProps.row.id }}</td>-->
<!--                    <td>{{ slotProps.row.categories.name }}</td>-->
<!--                    <td>{{ slotProps.row.order }}</td>-->
<!--                    <td>{{ slotProps.row.link }}</td>-->
<!--                    <td>-->
<!--                        노출 시작 : {{ slotProps.row.started_at }} ~<br>-->
<!--                        노출 종료 : {{ slotProps.row.ended_at }}-->
<!--                    </td>-->
<!--                    <td>{{ slotProps.row.views }}</td>-->
                    <td>
                        <router-link :to="`/admin/community/${slotProps.row.id}`"
                                     class="btn btn-info float-left mr-2">
                            수정
                        </router-link>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="articles" @pagination-change-page="getData" class="mb-0">
                        <span slot="prev-nav">‹</span>
                        <span slot="next-nav">›</span>
                    </pagination>
                </nav>
            </div>
        </template>
    </layout>
</template>

<script>
import Table from '@/components/admin/grid/Table.vue';
import ButtonOpen from '@/components/admin/button/ButtonOpen.vue';

// api
// import Community from '@/api/admin/banner/Community.js';

export default {
    name: 'AdminCommunity',

    components: {
        'table-grid': Table,
        'button-open': ButtonOpen,
    },
    data() {
        return {
            articles: {
                data: []
            },
            page: 1,
        }
    },
    mounted() {
        this.getData();
    },
    computed: {
        tableCol() {
            return [
                {
                    name: 'id',
                    text: '번호',
                    width: '6%'
                },
                {
                    name: 'title',
                    text: '제목',
                    width: '10%'
                },
                {
                    name: 'date',
                    text: '작성일자',
                    width: '8%'
                },
                {
                    name: 'commend',
                    text: '명령',
                    width: '22%'
                }
            ]
        },
    },
    methods: {
        // getData(page = this.page) {
        //     if (this.Helper.nullCheck(page)) {
        //         page = 1;
        //     }
        //
        //     let params = {
        //         page: page
        //     };
        //
        //     Community.getData(params).then(res => {
        //         this.articles = res.data.articles;
        //     }).catch(err => {
        //         this.articles = [];
        //     });
        // },
    }
}
</script>

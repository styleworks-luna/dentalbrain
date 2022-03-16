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
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.title }}</td>
                    <td>
                        {{ slotProps.row.created_at }}
                    </td>
                    <td>
                        <router-link :to="`/admin/community/${slotProps.row.id}/${page}`"
                                     class="btn btn-info float-left mr-2">
                            수정
                        </router-link>
                        <button class="btn btn-danger float-left" @click="destroy(slotProps.row.id)">삭제</button>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="articles" :limit=3 @pagination-change-page="getData" class="mb-0">
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
import Community from '@/api/admin/community/Community.js';

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
            page: this.$route.params.page || 1,
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
                    width: '10%'
                },
                {
                    name: 'title',
                    text: '제목',
                    width: '60%'
                },
                {
                    name: 'date',
                    text: '작성일자',
                    width: '20%'
                },
                {
                    name: 'commend',
                    text: '명령',
                    width: '10%'
                }
            ]
        },
    },
    methods: {
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }
            this.page = page;

            let params = {
                page: page
            };

            Community.getData(params).then(res => {
                this.articles = res.data.articles;

                // 뒤로가기 page에 따라 reload
                const path = `/admin/community/${page}`
                if (this.$route.path !== path) this.$router.push(path);
            }).catch(err => {
                this.articles = [];
            });
        },
        destroy(id) {
            Community.destroy(id).then(res => {
                alert(res.data.msg);
            })
        }
    }
}
</script>

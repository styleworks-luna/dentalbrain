<template>
    <layout title="회원정보 목록">
        <template v-slot:button>

        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="users.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.position }}</td>
                    <td>{{ slotProps.row.order }}</td>
                    <td>{{ slotProps.row.link }}</td>
                    <td>{{ slotProps.row.started_at }}{{ slotProps.row.ended_at }}</td>
                    <td>{{ slotProps.row.view }}</td>
                    <td>
                        <router-link :to="`/admin/banner/edit/${slotProps.row.id}`"
                                     class="btn btn-lg btn-info">
                            수정
                        </router-link>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="users" @pagination-change-page="getData" class="mb-0">
                        <span slot="prev-nav">‹</span>
                        <span slot="next-nav">›</span>
                    </pagination>
                </nav>
            </div>
        </template>
    </layout>
</template>

<script>
// component
import Table from '@/components/admin/grid/Table.vue';

// api
import Banner from '@/api/admin/banner/Banner.js';

export default {
    name: 'AdminUser',
    components: {
        'table-grid': Table,
    },
    data() {
        return {
            users: {
                data: []
            },
            page: 1
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
                    text: '번호'
                },
                {
                    name: 'position',
                    text: '종류'
                },
                {
                    name: 'order',
                    text: '중요도'
                },
                {
                    name: 'link',
                    text: '연결링크'
                },
                {
                    name: 'started_at',
                    text: '표시기간'
                },
                {
                    name: 'views',
                    text: '클릭회수'
                },
                {
                    name: 'commend',
                    text: '명령'
                }
            ]
        }
    },
    methods: {
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                page: page
            };

            Banner.getData(params).then(res => {
                console.log(res);
                this.faqs = res.data.banner;
            }).catch(err => {
                this.faqs = [];
            });
        },

    }
}
</script>

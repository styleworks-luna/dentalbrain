<template>
    <layout title="공지사항">
        <template v-slot:button>
            <router-link to="/admin/customer/notice/create"
                         class="btn btn-lg btn-info">
                공지사항 추가
            </router-link>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="notices.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>
                        <router-link :to="`/admin/customer/notice/${slotProps.row.id}`">
                            {{ slotProps.row.title }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.created_at }}</td>
                    <td>{{ slotProps.row.views }}</td>
                    <td>
                        <button-open :isOpen="slotProps.row.is_open"
                                     @setStatus="handleSetStatus(slotProps.row.id)"></button-open>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="notices" @pagination-change-page="getData" class="mb-0">
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
import ButtonOpen from '@/components/admin/button/ButtonOpen.vue';

// api
import Notice from '@/api/admin/customer/Notice.js';

export default {
    name: 'AdminNotice',
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen
    },
    data() {
        return {
            notices: {
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
                    name: 'title2',
                    text: '제목'
                },
                {
                    name: 'created_at',
                    text: '작성일'
                },
                {
                    name: 'views',
                    text: '조회수'
                },
                {
                    name: 'is_open',
                    text: '상태',
                    isSort: true
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

            Notice.getData(params).then(res => {
                this.notices = res.data.notice;
            }).catch(err => {
                this.notices = [];
            });
        },
        handleSetStatus(id) {
            Notice.setStatus(id).then(res => {
                this.getData();
                alert(res.data.msg);
            }).catch(err => {
                alert('오류');
            })
        }
    }
}
</script>

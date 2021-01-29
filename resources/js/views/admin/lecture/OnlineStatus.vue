<template>
    <layout title="온라인 강의 현황">
        <template v-slot:button>
            <router-link to="/admin/lecture/online/create"
                         class="btn btn-lg btn-info">
                온라인 강의 관리
            </router-link>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="lectures.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.user_id }}</td>
                    <td>{{ slotProps.row.email }}</td>
                    <td>{{ slotProps.row.phone }} </td>
                    <td>{{ slotProps.row.payment }} </td>
                    <td>{{ slotProps.row.watch }} </td>
                    <td>
                        <router-link :to="``"
                                     class="btn btn-info">
                            보기
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="``"
                                     class="btn btn-danger text-white">
                            결제취소</router-link>
                    </td>
                    <td>{{ slotProps.row.started_at }} </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="lectures" @pagination-change-page="getData" class="mb-0">
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

//api
import Online from '@/api/admin/lecture/Online.js'

export default {
    name: 'AdminOnlineStatus',
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen
    },
    data() {
        return {
            lectures: {
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
                    name: 'user_id',
                    text: '아이디'
                },
                {
                    name: 'email',
                    text: '소분류'
                },
                {
                    name: 'phone',
                    text: '강의 제목'
                },
                {
                    name: 'payment',
                    text: '수강현황'
                },
                {
                    name: 'watch',
                    text: '시청기간'
                },
                {
                    name: 'additional',
                    text: '추가정보'
                },
                {
                    name: 'cancel',
                    text: '취소'
                },
                {
                    name: 'started_at',
                    text: '신청일시'
                },
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

            Online.getData(params).then(res => {
                this.lectures = res.data.programs;
            }).catch(err => {
                this.lectures = [];
            });
        },
        handleSetStatus(id) {
            Online.setStatus(id).then(res => {
                this.getData();
                alert(res.data.msg);
            })
        }
    }
}
</script>

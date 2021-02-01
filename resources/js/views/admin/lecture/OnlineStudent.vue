<template>
    <layout :title="`수강 신청 신청 현황`">
        <template v-slot:button>

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
    name: 'AdminOnlineStudent',
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen
    },
    data() {
        return {
            lectures: {
                data: []
            }
        }
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
                    text: '이메일'
                },
                {
                    name: 'phone',
                    text: '연락처'
                },
                {
                    name: 'payment',
                    text: '결제금액'
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
        getData() {
            Online.getStudentsData().then(res => {
                console.log(res);
            }).catch(err => {
                this.lectures = [];
            });
        }
    }
}
</script>

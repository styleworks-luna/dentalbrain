<template>
    <layout title="회원정보 목록">
        <template v-slot:button>

        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="users.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.login_id }} </td>
                    <td>{{ slotProps.row.name }}</td>
                    <td>{{ slotProps.row.email }}</td>
                    <td>{{ slotProps.row.phone }}</td>
                    <td>{{ slotProps.row.job_id }}</td>
                    <td>
                        <router-link :to="`/admin/user/edit/${slotProps.row.id}`"
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
/*import User from '@/api/admin/user/User.js';*/

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
    },
    computed: {
        tableCol() {
            return [
                {
                    name: 'id',
                    text: '번호'
                },
                {
                    name: 'login_id',
                    text: '아이디'
                },
                {
                    name: 'name',
                    text: '이름'
                },
                {
                    name: 'email',
                    text: '이메일'
                },
                {
                    name: 'phone',
                    text: '전화번호'
                },
                {
                    name: 'job_id',
                    text: '직업군'
                },
                {
                    name: 'edit',
                    text: '정보수정'
                }
            ]
        }
    },
    methods: {

    }
}
</script>

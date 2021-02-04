<template>
    <layout title="회원정보 목록">
        <template v-slot:search>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <select-box class="form-control"
                                text="분류"
                                :value="job_name_id"
                                :options="jobOptions"
                                @setValue="handleSetJobyId"></select-box>

                    <div class="input-group">
                        <input class="form-control"
                               type="text"
                               placeholder="ID, 이름, 전화번호, 이메일"
                               v-model="keyword">
                        <span class="input-group-append">
                            <button class="btn btn-primary" type="submit">검색</button>
                        </span>
                    </div>
                </form>
            </div>
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
                    <td>{{ slotProps.row.job_name }}</td>
                    <td>
                        <router-link :to="`/admin/user/${slotProps.row.id}`"
                                     class="btn btn-info">
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
import SelectBox from '@/components/common/SelectBox.vue';

// api
import User from '@/api/admin/user/User.js';

export default {
    name: 'AdminUser',
    components: {
        'table-grid': Table,
        'select-box': SelectBox
    },
    data() {
        return {
            users: {
                data: []
            },
            jobOptions: [],
            job_name_id: '',
            keyword: '',
            page: 1
        }
    },
    mounted() {
        this.getData();
        this.getCategory();
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
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                job_name_id: this.job_name_id,
                keyword: this.keyword,
                page: page
            };

            User.getData(params).then(res => {
                this.users = res.data.user;
            }).catch(err => {
                this.users = [];
            });
        },
        getCategory() {
            User.getCategory().then(res => {
                this.jobOptions = res.data.userJob;
            });
        },
        handleSetJobyId(value) {
            this.job_name_id = value;
        },
    }
}
</script>

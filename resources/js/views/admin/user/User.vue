<template>
    <layout title="회원정보 목록">
        <template v-slot:search>
            <div class="float-left">
                <p style="font-size: 18px;">총 회원수: {{ users.data.length }}명 ( 일반회원: {{ basicUserNumber }}명 / 유료회원: {{ membershipUserNumber }}명 )</p>
            </div>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <select-box class="form-control"
                                text="회원"
                                :value="member"
                                :options="userOption"
                                @setValue="handleSetMember"></select-box>

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
                    <td>{{ slotProps.row.is_paid ? '유료회원' : '일반' }}</td>
                    <td>{{ slotProps.row.login_id }}</td>
                    <td>{{ slotProps.row.name }}</td>
                    <td>{{ slotProps.row.email }}</td>
                    <td>{{ slotProps.row.phone }}</td>
                    <td>{{ slotProps.row.job_name }}</td>
                    <td>
                        <router-link :to="`/admin/user/user/${slotProps.row.id}/${page}`"
                                     class="btn btn-info float-left">
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
        'select-box': SelectBox,
    },
    data() {
        return {
            users: {
                data: []
            },
            member: '',
            jobOptions: [],
            job_name_id: '',
            keyword: '',
            page: this.$route.params.page || 1
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
                    text: '번호',
                    width: '6%'
                },
                {
                    name: 'is_paid',
                    text: '회원구분',
                    width: '6%'
                },
                {
                    name: 'login_id',
                    text: '아이디',
                    width: '11%'
                },
                {
                    name: 'name',
                    text: '이름',
                    width: '12%'
                },
                {
                    name: 'email',
                    text: '이메일',
                    width: '25%'
                },
                {
                    name: 'phone',
                    text: '전화번호',
                    width: '15%'
                },
                {
                    name: 'job_id',
                    text: '직업군',
                    width: '15%'
                },
                {
                    name: 'edit',
                    text: '정보수정',
                    width: '10%'
                }
            ]
        },
        userOption() {
            return [
                {
                    id: 0,
                    name: '일반회원',
                },
                {
                    id: 1,
                    name: '유료회원',
                }
            ]
        },
        basicUserNumber() {
            var result, count = 0 ;
            result = this.users.data.filter(res => !res.has_membership);
            count = result.length;
            return count;
        },
        membershipUserNumber() {
            var result, count = 0 ;
            result = this.users.data.filter(res => res.has_membership);
            count = result.length;
            return count;
        }
    },
    methods: {
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }
            this.page = page;

            let params = {
                job_name_id: this.job_name_id,
                is_paid: this.member,
                keyword: this.keyword,
                page: page
            };

            User.getData(params).then(res => {
                console.log(res);
                this.users = res.data.user;
                // 뒤로가기 page에 따라 reload
                const path = `/admin/user/user/${page}`
                if (this.$route.path !== path) this.$router.push(path);
            }).catch(err => {
                this.users = [];
            });
        },
        getCategory() {
            User.getCategory().then(res => {
                this.jobOptions = res.data.userJob;
            });
        },
        handleSetMember(value) {
            this.member = value;
        },
        handleSetJobyId(value) {
            this.job_name_id = value;
        },
    }
}
</script>

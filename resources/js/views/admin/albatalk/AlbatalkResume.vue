<template>
    <layout title="구직 정보">
        <template v-slot:search>
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0" style="font-size: 12px">구직 정보 [ 전체 {{ total }}개 ]</p>
                <div>
                    <form @submit.prevent="getData">
                        <div class="input-group">
                            <input class="form-control"
                                   type="text"
                                   placeholder="제목"
                                   v-model="keyword">
                            <span class="input-group-append">
                            <button class="btn btn-primary" type="submit">검색</button>
                        </span>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="resumeList.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>
                        <router-link :to="`/admin/user/user/${slotProps.row.user_id}/1`">
                            {{ slotProps.row.user.login_id }}
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="`/admin/user/user/${slotProps.row.user_id}/1`">{{ slotProps.row.name }}
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="`/admin/user/user/${slotProps.row.user_id}/1`">{{ slotProps.row.email }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.phone }}</td>
                    <td>{{ slotProps.row.user.job_name }}</td>
                    <td>
                        <a :href="`/api/admin/resume/${slotProps.row.id}/pdf`"
                           class="btn btn-info mr-2" target="_blank">
                            보기
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-danger" @click="">추천</button>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="resumeList" :limit=3 @pagination-change-page="" class="mb-0">
                        <span slot="prev-nav">‹</span>
                        <span slot="next-nav">›</span>
                    </pagination>
                </nav>
            </div>
        </template>
    </layout>
</template>

<script>
// api
import Resume from "@/api/admin/albatalk/Resume.js"

// component
import Table from '@/components/admin/grid/Table.vue';

export default {
    name: "AlbaTalkResume",
    components: {
        'table-grid': Table,
    },
    computed: {
        tableCol() {
            return [
                {
                    name: 'id',
                    text: '번호',
                    width: '5%'
                },
                {
                    name: 'user_id',
                    text: '아이디',
                    width: '12%'
                },
                {
                    name: 'name',
                    text: '이름',
                    width: '12%'
                },
                {
                    name: 'email',
                    text: '이메일',
                    width: '18%'
                },
                {
                    name: 'phone',
                    text: '전화번호',
                    width: '18%'
                },
                {
                    name: 'job',
                    text: '직업군',
                    width: '15%'
                },
                {
                    name: 'status',
                    text: '이력서',
                    width: '10%'
                },
                {
                    name: 'function',
                    text: '추천하기',
                    width: '10%'
                },
            ]
        },
    },
    data() {
        return {
            resumeList: {
                data: [],
            },
            keyword: "",
            total: 0,
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            let params = {
                keyword: this.keyword
            }
            Resume.getData(params).then(res => {
                this.resumeList = res.data;
                this.total = res.data.total;
            }).catch(err => {
                this.resumeList = {};
            })
        }
    }
}
</script>

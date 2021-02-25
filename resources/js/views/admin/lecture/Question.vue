<template>
    <layout title="강의 질문내역">
        <template v-slot:search>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <select-box class="form-control"
                                :value="gubun"
                                :options="gubunOptions"
                                @setValue="handleSetGubun"></select-box>

                    <div class="input-group">
                        <input class="form-control"
                               type="text"
                               placeholder="강의제목, 질문내용"
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
                        :data="questions.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.user.login_id }}</td>
                    <td>{{ slotProps.row.user.email }}</td>
                    <td>
                        <a :href="`/lectures/${slotProps.row.lecture.program.id}`">
                            {{ slotProps.row.lecture.program.title }}
                        </a>
                    </td>
                    <td>
                        <router-link :to="`/admin/lecture/question/${slotProps.row.id}`">
                            {{ slotProps.row.question }}
                        </router-link>
                    </td>
                    <td>
                        <template v-if="slotProps.row.is_answer == 1 ">완료</template>
                        <template v-else>미완료</template>
                    </td>
                    <td>{{ slotProps.row.created_at }}</td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="questions" @pagination-change-page="getData" class="mb-0">
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

//api
import Question from '@/api/admin/lecture/Question.js';

export default {
    name: 'AdminQuestion',
    components: {
        'table-grid': Table,
        'select-box': SelectBox
    },
    data() {
        return {
            questions: {
                data: []
            },
            page: 1,
            gubun: 'all',
            keyword: '',
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
                    text: '이메일'
                },
                {
                    name: 'title',
                    text: '강의제목'
                },
                {
                    name: 'content',
                    text: '질문내용'
                },
                {
                    name: 'is_answer',
                    text: '답변여부'
                },
                {
                    name: 'question_date',
                    text: '질문일시'
                }
            ]
        },
        gubunOptions() {
            return [
                {
                    id: 'all',
                    name: '선택'
                },
                {
                    id: '0',
                    name: '미완료'
                },
                {
                    id: '1',
                    name: '완료'
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
                keyword: this.keyword,
                is_answer: this.gubun,
                page: page
            };

            console.log(params);

            Question.getData(params).then(res => {
                this.questions = res.data.question;
            }).catch(err => {
                this.questions = [];
            });
        },
        handleSetGubun(gubun) {
            this.gubun = gubun;
        }
    }
}
</script>

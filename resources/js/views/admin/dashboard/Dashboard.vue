<template>
    <div class="row" style="background-color: white;">
        <div class="col-xl" style="padding-top: 20px;">
            <div class="table-head overflow-hidden mb-2">
                <b class="float-left">강의 질문내역</b>
            </div>
            <table class="table text-center border-bottom">
                <thead>
                <tr>
                    <th scope="col">번호</th>
                    <th scope="col">아이디</th>
                    <th scope="col">강의제목</th>
                    <th scope="col">질문내용</th>
                    <th scope="col">질문일시</th>
                    <th scope="col">답변여부</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="question in questions">
                    <td>{{question.id}}</td>
                    <td>{{question.user.login_id}}</td>
                    <td><a :href="`/lectures/${question.lecture.program_id}`" class="question-tag">{{question.lecture.program.title}}</a></td>
                    <td><a :href="`/admin/lecture/question/${question.id}/1`" class="question-tag">{{question.question}}</a></td>
                    <td><a :href="`/admin/`">{{question.created_at}}</a></td>
                    <td v-if="question.is_answer==true">완료</td>
                    <td else>미완료</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-xl" style="padding-top: 20px;">
            <div class="table-head overflow-hidden mb-2">
                <b class="float-left">고객센터 문의내역</b>
            </div>
            <table class="table text-center border-bottom">
                <thead>
                <tr>
                    <th scope="col">번호</th>
                    <th scope="col">이름</th>
                    <th scope="col">제목</th>
                    <th scope="col">작성일</th>
                    <th scope="col">답변여부</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="inquiry in inquiries">
                    <td>{{inquiry.id}}</td>
                    <td>{{inquiry.name}}</td>
                    <td><a :href="`/admin/customer/inquire/${inquiry.id}/1`" class="inquiry-title">{{inquiry.title}}</a></td>
                    <td>{{inquiry.created_at}}</td>
                    <td v-if="inquiry.is_answer==true">완료</td>
                    <td else>미완료</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import Table from '@/components/admin/grid/Table.vue';

// api
import Dashboard from '@/api/admin/dashboard/Dashboard.js';

export default {
    name: "Dashboard",
    components: {
        "table-grid": Table,
    },
    data() {
        return {
            inquiries: [],
            questions: [],
        }
    },
    mounted() {
        this.getInquiries();
        this.getQuestion();
    },
    methods: {
        getInquiries() {
            Dashboard.getInquiries().then(res => {
                this.inquiries = res.data.inquiries;
            })
        },
        getQuestion() {
            Dashboard.getQuestion().then(res => {
                this.questions = res.data.questions;
            })
        },
    }
}
</script>

<style scoped>
table tbody tr:hover {
    background-color: #DEEBF7;
}
a {
    display: block;
    color: #333;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.question-tag {
    max-width: 9.6vw;
}

.inquiry-title {
    max-width: 15vw;
}

a:hover {
    color: #333;
    text-decoration: underline;
}
</style>

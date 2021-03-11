<template>
    <layout title="추가 정보 입력" class="student-additional">
        <template v-slot:body>
            <ul class="question-list-wrap">
                <li v-for="survey in surveys" class="question-list">
                    {{ survey.question }}
                    <ul>
                        <li class="answer-list" v-for="answer in survey.answers">
                            <p v-if="!answer.file">
                                {{ answer.content || (answer.address + ' ' + answer.address_detail) }}
                            </p>
                            <a :href="answer.file.url" download v-else>{{ answer.file.name }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </template>
    </layout>
</template>

<script>
import Common from '@/api/admin/lecture/Common.js'
export default {
    name: 'AdminOnlineAdditional',
    data() {
        return {
            program_id: '',
            student_id: '',
            surveys: []
        }
    },
    mounted() {
        this.getData();
    },
    created() {
        this.program_id = this.$route.params.program_id;
        this.student_id = this.$route.params.student_id;
    },
    methods: {
        getData() {
            Common.getAdditional(this.program_id,this.student_id).then(res => {
                this.surveys = res.data.result;
            }).catch(err => {
            });
        },
    }
}
</script>

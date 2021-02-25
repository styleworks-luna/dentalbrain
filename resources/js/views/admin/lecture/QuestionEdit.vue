<template>
    <layout title="질문내역(상세)" class="inquire">
        <template v-if="Object.keys(data).length > 0" v-slot:body>
            <div>
                <single-group name="번호" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ id }}
                    </template>
                </single-group>

                <single-group name="질문일시" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.created_at }}
                    </template>
                </single-group>
            </div>

            <div>
                <single-group name="아이디" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.user.login_id }}
                    </template>
                </single-group>

                <single-group name="이름" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.user.name }}
                    </template>
                </single-group>
            </div>

            <div>
                <single-group name="이메일" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.user.email }}
                    </template>
                </single-group>

                <single-group name="연락처" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.user.phone }}
                    </template>
                </single-group>
            </div>
            <div>
                <single-group name="질문내용" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.question }}
                    </template>
                </single-group>

                <single-group name="답변상태" :isRequired="true" :size="6" :isRow="true">
                    <template v-slot:content>
                        <div class="float-left">
                            <select-box class="form-control "
                                        :value="data.is_answer"
                                        :options="answerOption"
                                        @setValue="handleSetAnswerId"></select-box>
                        </div>
                        <div class="float-left answer-time">
                            <p v-if="data.is_answer == 1">답변 시간 : {{ data.answered_at }}</p>
                        </div>
                    </template>
                </single-group>
            </div>
        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info"
                        @click="update">저장
                </button>
                <router-link to="/admin/lecture/question"
                             class="btn btn-dark">목록
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// api
import Question from '@/api/admin/lecture/Question.js';
// mixins
import {QuestionMixin} from '@/mixins/admin/lecture/Question.js';

export default {
    name: 'AdminQuestionEdit',
    mixins: [
        QuestionMixin
    ],
    data() {
        return {
            id: '',
            data: {}
        }
    },
    created() {
        this.id = this.$route.params.id;
    },
    mounted() {
        this.getEditData();
    },
    methods: {
        getEditData() {
            Question.getEditData(this.id).then(res => {
                this.data = res.data.question;
            });
        },
        update() {
            let data = {
                is_answer: this.is_answer
            };

            Question.update(this.id, data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/lecture/question');
            })
        },
    }
}
</script>

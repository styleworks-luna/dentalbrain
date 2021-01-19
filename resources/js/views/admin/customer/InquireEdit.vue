<template>
    <layout title="문의내역(상세)" class="test">
        <template v-slot:body>

            <div>
                <single-group name="번호" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ id }}
                    </template>
                </single-group>

                <single-group name="작성일" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.created_at }}
                    </template>
                </single-group>
            </div>

            <div>
                <single-group name="이메일" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.email }}
                    </template>
                </single-group>

                <single-group name="이름" class="float-left w-50" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.name }}
                    </template>
                </single-group>
            </div>

            <div>
                <single-group name="연락처" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.phone }}
                    </template>
                </single-group>

                <single-group name="문의내용" :size="9" :isRow="true">
                    <template v-slot:content>
                        {{ data.content }}
                    </template>
                </single-group>

                <single-group name="구분" :size="1" :isRequired="true" :isRow="true">
                    <template v-slot:content>
                        <select-box class="form-control"
                                    :value="data.category_id"
                                    :options="categoryOptions"
                                    @setValue="handleSetCategoryId"></select-box>
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
                            <p v-if="data.answered_at !== null">답변 시간 : {{ data.answered_at }}</p>
                        </div>
                    </template>
                </single-group>
            </div>
        </template>

        <template v-slot:footer>
            <div class="float-left">
                <button type="button" class="btn btn-danger"
                        @click="destroy">삭제
                </button>
            </div>

            <div class="float-right">
                <button type="submit" class="btn btn-info"
                        @click="update">저장
                </button>
                <router-link to="/admin/customer/inquire"
                             class="btn btn-dark">목록
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// api
import Inquire from '@/api/admin/customer/Inquire.js';

// mixins
import {InquireMixin} from '@/mixins/admin/customer/Inquire.js';

export default {
    name: 'AdminInquireEdit',
    mixins: [
        InquireMixin
    ],
    data() {
        return {
            id: '',
            data: []
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
            Inquire.getEditData(this.id).then(res => {
                const result = res.data.inquiry;

                this.data = result;
            });
        },
        update() {
            let data = {
                category_id: this.category_id,
                is_answer: this.is_answer
            };

            Inquire.update(this.id, data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/customer/inquire');
            }).catch(err => {
                alert('오류');
            });
        },
        destroy() {
            Inquire.destroy(this.id).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/customer/inquire');
            })
        }
    }
}
</script>

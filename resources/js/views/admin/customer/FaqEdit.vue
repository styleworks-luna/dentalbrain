<template>
    <layout title="FAQ 수정">
        <template v-slot:body>
            <!-- 제목 -->
            <form-single-group name="질문" :isRequired="true" :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control" placeholder="질문을 입력해 주세요."
                           v-model="question">
                </template>
            </form-single-group>

            <!-- 세부내용 -->
            <form-single-group name="답변" :isRequired="true" :size="9">
                <template v-slot:content>
                    <textarea class="form-control" rows="9" placeholder="답변을 입력해 주세요."
                              v-model="answer"></textarea>
                </template>
            </form-single-group>

            <!-- 카테고리 타입 -->
            <form-single-group name="카테고리 타입" :isRequired="true" :size="6">
                <template v-slot:content>
                    <select-box class="form-control"
                                :value="category_id"
                                :options="categoryOptions"
                                @setValue="handleSetCategoryId"></select-box>
                </template>
            </form-single-group>

            <!-- 공개 여부 -->
            <form-single-group name="공개여부" :isRequired="true" :size="6">
                <template v-slot:content>
                    <button-check :propsCheck="is_open"
                                  @isChecked="handleSetIsOpen"></button-check>
                </template>
            </form-single-group>
        </template>

        <template v-slot:footer>
            <div class="float-left">
                <button type="button" class="btn btn-danger"
                        @click="destroy">삭제</button>
            </div>

            <div class="float-right">
                <button type="submit" class="btn btn-info"
                        @click="update">수정</button>
                <router-link to="/admin/customer/faq"
                             class="btn btn-dark">취소</router-link>
            </div>
        </template>
    </layout>
</template>

<script>
    // api
    import Faq from '@/api/admin/customer/Faq.js';

    // mixins
    import { FaqMixin, FaqDestory } from '@/mixins/admin/customer/Faq.js';

    export default {
        name: 'AdminFaqEdit',
        mixins: [
            FaqMixin,
            FaqDestory
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
                Faq.getEditData(this.id).then(res => {
                    const result = res.data.faq;

                    this.question = result.question;
                    this.answer = result.answer;
                    this.category_id = result.category_id;
                    this.is_open = result.is_open;
                });
            },
            update() {
                let data = {
                    question: this.question,
                    answer: this.answer,
                    category_id: this.category_id,
                    is_open: this.is_open
                };

                Faq.update(this.id, data).then(res => {
                    alert(res.data.msg);
                    this.$router.push('/admin/customer/faq');
                }).catch(err => {
                    alert('오류');
                });
            },
            destroy() {
                Faq.destroy(this.id).then(res => {
                    alert(res.data.msg);
                    this.$router.push('/admin/customer/faq');
                })
            }
        }
    }
</script>

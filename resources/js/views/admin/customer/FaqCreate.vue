<template>
    <layout title="FAQ 생성">
        <template v-slot:body>
            <!-- 제목 -->
            <form-single-group name="질문"
                               :isRow="true"
                               :isRequired="true"
                               :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control" placeholder="질문을 입력해 주세요."
                           v-model="question">
                </template>
            </form-single-group>

            <!-- 세부내용 -->
            <form-single-group name="답변"
                               :isRow="true"
                               :isRequired="true"
                               :size="9">
                <template v-slot:content>
                    <textarea class="form-control" rows="9" placeholder="답변을 입력해 주세요."
                              v-model="answer"></textarea>
                </template>
            </form-single-group>

            <!-- 카테고리 타입 -->
            <form-single-group name="카테고리 타입"
                               :isRow="true"
                               :isRequired="true"
                               :size="6">
                <template v-slot:content>
                    <select-box class="form-control"
                                :value="category_id"
                                :options="categoryOptions"
                                @setValue="handleSetCategoryId"></select-box>
                </template>
            </form-single-group>

            <!-- 공개 여부 -->
            <form-single-group name="공개여부"
                               :isRow="true"
                               :isRequired="true"
                               :size="6">
                <template v-slot:content>
                    <button-check :propsCheck="is_open"
                                  @isChecked="handleSetIsOpen"></button-check>
                </template>
            </form-single-group>
        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info" @click="create">저장</button>
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
    import { FaqMixin } from '@/mixins/admin/customer/Faq.js';

    export default {
        name: 'AdminFaqCreate',
        mixins: [
            FaqMixin
        ],
        methods: {
            create() {
                let data = {
                    question: this.question,
                    answer: this.answer,
                    category_id: this.category_id,
                    is_open: this.is_open
                };

                Faq.create(data).then(res => {
                    alert(res.data.msg);
                    this.$router.push('/admin/customer/faq');
                }).catch(err => {
                    alert('오류');
                });
            }
        }
    }
</script>

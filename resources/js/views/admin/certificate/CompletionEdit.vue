<template>
    <layout title="교육수료증 수정" class="faq">
        <template v-slot:body>
            <single-group name="수료증 제목 입력"
                               :isRow="true"
                               :isRequired="true"
                               :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control"
                           v-model="question">
                </template>
            </single-group>

            <single-group name="본문 내용 입력"
                               :isRow="true"
                               :isRequired="true"
                               :size="9">
                <template v-slot:content>
                    <textarea class="form-control" rows="9" placeholder="최대 3줄 / 80자 이내"
                              v-model="answer"></textarea>
                </template>
            </single-group>

            <single-group name="하단 내용 입력"
                               :isRow="true"
                               :isRequired="true"
                               :size="9">
                <template v-slot:content>
                    <textarea class="form-control" rows="5" placeholder="최대 25자 이내"
                              v-model="answer"></textarea>
                </template>
            </single-group>
        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info" @click="create">등록</button>
                <router-link to="/admin/certificate/information"
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
        name: 'CompletionEdit',
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
                    this.$router.push('/admin/customer/faq/1');
                })
            }
        }
    }
</script>

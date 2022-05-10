<template>
    <layout title="자격증 수정" class="faq">
        <template v-slot:body>
            <single-group name="자격증 제목 입력"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control"
                           v-model="title">
                </template>
            </single-group>

            <single-group name="자격번호(입력된 수치부터 순차적으로 카운팅 됩니다.)"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control"
                           v-model="certificateNumber">
                </template>
            </single-group>

            <single-group name="자격등급"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control"
                           v-model="certificateRate">
                </template>
            </single-group>

            <single-group name="본문 내용 입력"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <textarea class="form-control" rows="9" placeholder="최대 3줄 / 80자 이내"
                              v-model="content"></textarea>
                </template>
            </single-group>
        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info" @click="update">등록</button>
                <button class="btn btn-dark" @click.prevent="$router.back();">취소 </button>
            </div>
        </template>
    </layout>
</template>

<script>
import SingleGroup from '@/components/admin/form/SingleGroup.vue';

import Qualification from '@/api/admin/certificate/Qualification.js';

export default {
    name: 'CertificateEdit',
    components: {
        'single-group': SingleGroup,
    },
    created() {
        this.id = this.$route.params.id;
    },
    data() {
        return {
            title: '',
            certificateNumber: '',
            certificateRate: '',
            content: '',
        }
    },
    mounted() {
      this.getEditData();
    },
    methods: {
        getEditData() {
            Qualification.getEditData(this.id).then(res => {
                this.title = res.data[0].title;
                this.certificateNumber = res.data[0].certification_number;
                this.certificateRate = res.data[0].grade;
                this.content = res.data[0].content;
            })
        },
        update() {
            let data = {
                title: this.title,
                certification_number: this.certificateNumber,
                grade: this.certificateRate,
                content: this.content
            };
            Qualification.update(this.id, data).then(res => {
                alert(res.data.msg);
                this.$router.back();
            })
        }
    }
}
</script>

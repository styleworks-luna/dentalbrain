<template>
    <layout title="자격증 생성" class="faq">
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
                <button type="submit" class="btn btn-info" @click="create">등록</button>
                <router-link to="/admin/certificate/information"
                             class="btn btn-dark">취소
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>

export default {
    name: 'CertificateCreate',
    data() {
        return {
            title: '',
            certificateNumber: '',
            certificateRate: '',
            content: '',
        }
    },
    methods: {
        create() {
            let data = {
                title: this.title,
                certificateNumber: this.certificateNumber,
                certificateRate: this.certificateRate,
                content: this.content
            };
        }
    }
}
</script>

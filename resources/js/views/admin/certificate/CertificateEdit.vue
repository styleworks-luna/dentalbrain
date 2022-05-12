<template>
    <div class="certificate-container">
        <div class="certificate-wrap">
            <div class="card card-left h-100">
                <div class="card-header">
                    <h1 class="float-left mb-0 pt-2 pb-2 font-xl">자격증 생성</h1>
                </div>
                <div class="card-body">
                    <single-group name="자격증 제목 입력"
                                  :isRow="true"
                                  :isRequired="true"
                                  :size="9">
                        <template v-slot:content>
                            <input type="text" class="form-control mb-3"
                                   v-model="title">
                        </template>
                    </single-group>

                    <single-group name="자격번호(입력된 수치부터 순차적으로 카운팅 됩니다.)"
                                  :isRow="true"
                                  :isRequired="true"
                                  :size="9">
                        <template v-slot:content>
                            <input type="text" class="form-control mb-3"
                                   v-model="certificateNumber">
                        </template>
                    </single-group>

                    <single-group name="자격등급"
                                  :isRow="true"
                                  :isRequired="true"
                                  :size="9">
                        <template v-slot:content>
                            <input type="text" class="form-control mb-3"
                                   v-model="certificateRate">
                        </template>
                    </single-group>

                    <single-group name="본문 내용 입력"
                                  :isRow="true"
                                  :isRequired="true"
                                  :size="9">
                        <template v-slot:content>
                    <textarea class="form-control mb-3" rows="9" placeholder="최대 3줄 / 80자 이내"
                              v-model="content"></textarea>
                        </template>
                    </single-group>

                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button type="submit" class="btn btn-info" @click="update">등록</button>
                        <button class="btn btn-dark" @click.prevent="$router.back();">취소</button>
                    </div>
                </div>
            </div>
            <div class="card card-right qualification h-100">
                <div class="card-header">
                    <h1 class="float-left mb-0 pt-2 pb-2 font-xl">미리보기</h1>
                </div>
                <div class="card-body">
                    <img src="/images/admin/KDMA_mark.svg" class="certificate-logo" alt="KDMA">
                    <img src="/images/admin/KDMA_light_mark.svg" class="certificate-background-logo" alt="KDMA">
                    <p class="certificate-number">자격번호 : {{ certificateNumber }}</p>
                    <h3 class="certificate-title">자 격 증</h3>
                    <div class="certificate-information-wrap">
                        <div class="certificate-text-wrap">
                            <p class="certificate-name">성&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;명 : 홍 길 동</p>
                            <p class="certificate-birth">생년월일 : 2001.01.10</p>
                            <p class="certificate-grade">자격등급 : {{ certificateRate }}</p>
                        </div>
                        <div class="certificate-image-wrap">
                            <div class="sample-image"></div>
                        </div>
                    </div>
                    <pre class="certificate-content">{{ content }}</pre>
                    <p class="certificate-date">{{ date }}</p>
                    <div class="certificate-associate"><span>대한치과위생사협회</span> <span>대한치과의료관리학회</span></div>
                    <div class="certificate-main-associate-wrap">
                        <p class="certificate-main-associate">대한치과경영관리협회</p>
                        <img src="/images/admin/sign.png" class="sign" alt="SIGN">
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    computed: {
        date() {
            const date = new Date();
            const year = date.getFullYear();
            let month = date.getMonth() + 1;
            let day = date.getDate();

            if (month < 10) {
                month = `0${month}`;
            }

            if (day < 10) {
                day = `0${day}`;
            }

            return `${year}년 ${month}월 ${day}일`;
        },
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
            });
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

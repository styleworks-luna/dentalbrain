<template>
    <div class="certificate-container">
        <div class="certificate-wrap">
            <div class="card card-left h-100">
                <div class="card-header">
                    <h1 class="float-left mb-0 pt-2 pb-2 font-xl">교육수료증 생성</h1>
                </div>
                <div class="card-body">
                    <single-group name="협회"
                                  :isRow="true"
                                  :isRequired="true"
                                  :size="9">
                        <template v-slot:content>
                            <select-box class="form-control mb-3"
                                        :value="categoryId"
                                        :options="certificateCategoryOptions"
                                        @setValue="handleSetCategoryId"></select-box>
                        </template>
                    </single-group>
                    <single-group name="수료증 제목 입력"
                                  :isRow="true"
                                  :isRequired="true"
                                  :size="9">
                        <template v-slot:content>
                            <input type="text" class="form-control mb-3"
                                   v-model="title">
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

                    <single-group name="하단 내용 입력"
                                  :isRow="true"
                                  :isRequired="true"
                                  :size="9">
                        <template v-slot:content>
                    <textarea class="form-control mb-3" rows="5" placeholder="최대 25자 이내"
                              v-model="subContent"></textarea>
                        </template>
                    </single-group>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button type="submit" class="btn btn-info" @click="create">등록</button>
                        <button class="btn btn-dark" @click.prevent="$router.back();">취소</button>
                    </div>
                </div>
            </div>
            <div class="card card-right h-100">
                <div class="card-header">
                    <h1 class="float-left mb-0 pt-2 pb-2 font-xl">미리보기</h1>
                </div>
                <div class="card-body">
                    <img src="/images/admin/KDMA_mark.svg" class="certificate-logo" alt="KDMA">
                    <img src="/images/admin/KDMA_light_mark.svg" class="certificate-background-logo" alt="KDMA">
                    <h3 class="certificate-title">교 육 수 료 증</h3>
                    <p class="certificate-name">성&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;명 : 홍 길 동</p>
                    <pre class="certificate-content">{{ content }}</pre>
                    <p class="certificate-sub-content">{{ subContent }}</p>
                    <p class="certificate-date">{{ date }}</p>
                    <template v-if="categoryId == 1">
                        <div class="certificate-associate"><span>대한치과위생사협회</span> <span>대한치과의료관리학회</span></div>
                    </template>
                    <template v-else-if="categoryId == 2" >
                        <div class="certificate-associate"><span style="margin:0">한국치위생감염관리학회</span></div>
                    </template>
                    <template v-else-if="categoryId == 3" >
                        <div class="certificate-associate"><span style="margin:0">Oral Rehabilitation Society</span></div>
                    </template>
                    <template v-else-if="categoryId == 4" >
                        <div class="certificate-associate"><span style="margin:0">(주) 브레인스펙</span></div>
                    </template>
                    <template v-else-if="categoryId == 5" >
                        <div class="certificate-associate"><span>Oral Rehabilitation Society</span> <span>대한구강위생관리학회</span></div>
                    </template>
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
import SelectBox from '@/components/common/SelectBox.vue';
import Completion from '@/api/admin/certificate/Completion.js';

export default {
    name: 'CompletionCreate',
    components: {
        'single-group': SingleGroup,
        'select-box': SelectBox,
    },
    data() {
        return {
            certificateCategoryOptions: [],
            categoryId: '1',
            title: '',
            content: '',
            subContent: '',
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
        this.getCategory();
    },
    methods: {
        getCategory() {
            Completion.getCategory().then(res => {
                this.certificateCategoryOptions = res.data.completionCategory;
            });
        },
        create() {
            let data = {
                category_id : this.categoryId,
                title: this.title,
                content: this.content,
                bottom_content: this.subContent,
            };
            Completion.create(data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/certificate/information');
            });
        },
        handleSetCategoryId(value) {
            this.categoryId = value;
        },
    }
}
</script>

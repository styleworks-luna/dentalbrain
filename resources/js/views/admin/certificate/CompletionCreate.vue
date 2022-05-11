<template>
    <div>
        <layout title="교육수료증 생성" class="faq">
            <template v-slot:body>
                <single-group name="수료증 제목 입력"
                              :isRow="true"
                              :isRequired="true"
                              :size="9">
                    <template v-slot:content>
                        <input type="text" class="form-control"
                               v-model="title">
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

                <single-group name="하단 내용 입력"
                              :isRow="true"
                              :isRequired="true"
                              :size="9">
                    <template v-slot:content>
                    <textarea class="form-control" rows="5" placeholder="최대 25자 이내"
                              v-model="subContent"></textarea>
                    </template>
                </single-group>
            </template>

            <template v-slot:footer>
                <div class="float-right">
                    <button type="submit" class="btn btn-info" @click="create">등록</button>
                    <button class="btn btn-dark" @click.prevent="$router.back();">취소</button>
                </div>
            </template>
        </layout>
        <layout title="미리보기" class="show">
            <template v-slot:body>

            </template>
        </layout>
    </div>
</template>

<script>
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import Completion from '@/api/admin/certificate/Completion.js';

export default {
    name: 'CompletionCreate',
    components: {
        'single-group': SingleGroup,
    },
    data() {
        return {
            title: '',
            content: '',
            subContent: '',
        }
    },
    methods: {
        create() {
            let data = {
                title: this.title,
                content: this.content,
                bottom_content: this.subContent,
            };
            Completion.create(data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/certificate/information');
            });
        }
    }
}
</script>

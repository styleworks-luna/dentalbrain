<template>
    <layout title="공지사항 생성">
        <template v-slot:body>
            <!-- 제목 -->
            <form-single-group name="제목" :isRequired="true" :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control" placeholder="제목을 입력해 주세요."
                           v-model="title">
                </template>
            </form-single-group>

            <!-- 세부내용 -->
            <form-single-group name="내용" :isRequired="true" :size="9">
                <template v-slot:content>
                    <textarea class="form-control" rows="9" placeholder="내용을 입력해 주세요."
                              v-model="content"></textarea>
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
            <div class="float-right">
                <button type="submit" class="btn btn-info" @click="create">저장</button>
                <router-link to="/admin/customer/notice"
                             class="btn btn-dark">취소</router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// api
import Notice from '@/api/admin/customer/Notice.js';

// mixins
import { NoticeMixin } from '@/mixins/admin/customer/Notice.js';

export default {
    name: 'AdminNoticeCreate',
    mixins: [
        NoticeMixin
    ],
    methods: {
        create() {
            let data = {
                title: this.title,
                content: this.content,
                is_open: this.is_open
            };

            Notice.create(data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/customer/notice');
            }).catch(err => {
                alert('오류');
            });
        }
    }
}
</script>

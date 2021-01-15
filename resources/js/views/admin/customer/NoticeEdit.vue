<template>
    <layout title="공지사항 수정">
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
            <div class="float-left">
                <button type="button" class="btn btn-danger"
                        @click="destroy">삭제</button>
            </div>

            <div class="float-right">
                <button type="submit" class="btn btn-info"
                        @click="update">수정</button>
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
    name: 'AdminNoticeEdit',
    mixins: [
        NoticeMixin
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
            Notice.getEditData(this.id).then(res => {
                const result = res.data.notice;

                this.title = result.title;
                this.content = result.content;
                this.is_open = result.is_open;
            });
        },
        update() {
            let data = {
                title: this.title,
                content: this.content,
                is_open: this.is_open
            };

            Notice.update(this.id, data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/customer/notice');
            }).catch(err => {
                alert('오류');
            });
        },
        destroy() {
            Notice.destroy(this.id).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/customer/notice');
            })
        }
    }
}
</script>

<template>
    <layout title="커뮤니티 내용 입력" class="community">
        <template v-slot:body>

            <!-- 제목 -->
            <single-group name="제목"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control" placeholder="제목을 입력해주세요."
                           v-model="title">
                </template>
            </single-group>

            <!-- 분류 -->
            <single-group name="분류 선택"
                          class="form-type"
                          :isRequired="true"
                          :isRow="true"
                          :size="9">
                <template v-slot:content>
                    <select-box class="form-control mr-3"
                                :text="'분류'"
                                :value="category_id"
                                :options="categoryOptions"
                                @setValue="handleSetCategoryId"></select-box>
                </template>
            </single-group>

            <!-- 작성자 -->
            <single-group name="작성자"
                          :isRow="true"
                          :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control" placeholder="작성자을 입력해주세요."
                           v-model="writer">
                </template>
            </single-group>

            <!-- 노출기간 -->
            <single-group name="날짜"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content class="overflow-hidden">
                    <date-picker :time="date" @setTime="handleSetTime"></date-picker>
                </template>
            </single-group>

            <!-- 상세 정보 입력 -->
            <single-group name="상세 정보 입력" :isRequired="true" :size="12">
                <template v-slot:content>
                    <editor :content="content"
                            :uploadImageUrl="`/api/admin/article/upload/image`"
                            :uploadFileUrl="`/api/admin/article/upload/file`"
                            @setEditor="handleSetEditor"></editor>
                </template>
            </single-group>

            <!-- 공개 여부 -->
            <single-group name="공개여부"
                          :isRow="true"
                          :isRequired="true"
                          :size="6">
                <template v-slot:content>
                    <button-check :propsCheck="is_open"
                                  @isChecked="handleSetIsOpen"></button-check>
                </template>
            </single-group>

        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info" @click="update">저장</button>
                <router-link :to="`/admin/community/${page}`"
                             class="btn btn-dark">취소
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// api
import Community from '@/api/admin/community/Community.js';

import  {CommunityMixin}  from '@/mixins/admin/community/Community.js';

export default {
    name: 'AdminBannerCreate',
    mixins: [
        CommunityMixin
    ],
    data() {
      return {
          page: this.$route.params.page,
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
            Community.getEditData(this.id).then(res => {
                const result = res.data.article;

                this.title = result.title;
                this.category_id = result.category_id;
                this.writer = result.writer
                this.content = result.content;
                this.is_open = result.is_open;
                this.date = result.date;
            });
        },
        update() {
            let data = {
                title: this.title,
                category_id: this.category_id,
                content: this.content,
                writer: this.writer,
                is_open: this.is_open,
                date: this.Helper.dateFormatYDM(this.date),
            };

            Community.update(this.id, data).then(res => {
                alert(res.data.msg);
                this.$router.push(`/admin/community/${this.page}`);
            })
        },
        handleSetTime(time) {
            this.date = time;
        },

    }
}
</script>

<template>
    <layout title="커뮤니티 내용 입력" class="community">
        <template v-slot:body>

            <!-- 제목 -->
            <single-group name="제목"
                          :isRow="true"
                          :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control" placeholder="제목을 입력해주세요."
                           v-model="title">
                </template>
            </single-group>

            <!-- URL -->
            <single-group name="연결주소"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control" placeholder="URL을 입력해주세요."
                           v-model="link">
                    <p class="d-block mt-2">배너 클릭 시 연결 될 URL 주소를 입력해 주세요.</p>
                </template>
            </single-group>

            <!-- 이미지 -->
            <single-group name="이미지"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <image-upload :inputId="'desktop' + thumbnail.id"
                                  :initFile="thumbnail"
                                  @setImage="updateThumbnail"></image-upload>
                </template>
            </single-group>

            <!-- 노출기간 -->
            <single-group name="날짜"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content class="overflow-hidden">
                    <date-picker @setTime="handleSetStartTime"></date-picker>
                </template>
            </single-group>

        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info" @click="create">저장</button>
                <router-link to="/admin/banner"
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
    methods: {
        create() {
            let data = {
                title: this.title,
                link: this.link,

                thumbnail_id: this.thumbnail.id,

                date: this.Helper.dateFormatYDM(this.started_at),
            };

            Community.create(data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/community');
            })
        },
        handleSetStartTime(time) {
            this.started_at = time;
        },
        handleSetEndTime(time) {
            this.ended_at = time;
        }

    }
}
</script>

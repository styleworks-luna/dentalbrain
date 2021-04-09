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
                    <date-picker :time="date" @setTime="handleSetTime"></date-picker>
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
                this.link = result.link;

                this.thumbnail = result.thumbnail;

                this.date = this.Helper.dateFormatYDM(result.date);
            });
        },
        update() {
            let data = {
                title : this.title,
                link : this.link,

                thumbnail_id : this.thumbnail.id,

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

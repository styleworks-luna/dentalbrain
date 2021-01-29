<template>
    <layout title="배너등록" class="banner">
        <template v-slot:body>
            <!-- 종류 -->
            <single-group name="종류"
                          :isRow="true"
                          :isRequired="true"
                          :size="6">
                <template v-slot:content>
                    <select-box class="form-control"
                                :value="position"
                                :options="bannerOptions"
                                @setValue="handleSetBannerCategoryId"></select-box>
                </template>
            </single-group>

            <!-- 중요도 -->
            <single-group name="중요도"
                          :isRow="true"
                          :isRequired="true"
                          :size="6">
                <template v-slot:content>
                    <select-box class="form-control"
                                :value="order"
                                :options="orderOptions"
                                @setValue="handleSetOrderCategoryId"></select-box>
                    <p class="d-block mt-2">중요도 값이 클수록 먼저 나오고, 같으면 동일한 중요도로 등록 된 배너가 랜덤 노출 됩니다.</p>
                </template>
            </single-group>

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
                    <image-upload :inputId="'desktop' + desktop_file.id"
                                  :initFile="desktop_file"
                                  @setImage="updateDesktopFile"></image-upload>
                    <p class="tips">PC 배너로 노출 될 이미지 업로드 (PC 배너 등록 시 첨부)</p>

                    <image-upload :inputId="'mobile' + mobile_file.id"
                                  :initFile="mobile_file"
                                  @setImage="updateMobileFile"></image-upload>
                    <p>Mobile 배너로 노출 될 이미지 업로드 (모바일 배너 등록 시 첨부)</p>
                </template>
            </single-group>

            <!-- 노출기간 -->
            <single-group name="노출기간"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content class="overflow-hidden">
                    <date-picker @setTime="handleSetStartTime"></date-picker>
                    <span class="float-left mr-2 ml-2 d-block">~</span>
                    <date-picker @setTime="handleSetEndTime"></date-picker>
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
import Banner from '@/api/admin/banner/Banner.js';

// mixins
import {BannerMixin} from '@/mixins/admin/banner/Banner.js';

export default {
    name: 'AdminBannerCreate',
    mixins: [
        BannerMixin
    ],
    data() {
        return {}
    },
    methods: {
        create() {
            let data = {
                position: this.position,
                order: this.order,

                title: this.title,
                link: this.link,

                desktop_file_id: this.desktop_file.id,
                mobile_file_id: this.mobile_file.id,

                started_at: this.Helper.dateFormatYDM(this.started_at),
                ended_at: this.Helper.dateFormatYDM(this.ended_at),

                is_open: this.is_open,
            };

            Banner.create(data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/banner');
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

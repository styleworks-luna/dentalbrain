<template>
    <layout title="배너수정" class="banner">
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
                    <datepicker class="date-picker start-time float-left" placeholder="시작 날짜"
                                valueType="format"
                                :format="'yyyy-MM-dd'"
                                :language="ko"
                                :required="true"
                                input-class="datepicker form-control"
                                v-model="started_at"></datepicker>
                    <span class="float-left">~</span>
                    <datepicker class="date-picker end-time float-left" placeholder="종료 날짜"
                                valueType="format"
                                :format="'yyyy-MM-dd'"
                                :language="ko"
                                :required="true"
                                input-class="datepicker form-control"
                                v-model="ended_at"></datepicker>
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
                <router-link to="/admin/banner"
                             class="btn btn-dark">취소</router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// components
import Datepicker from 'vuejs-datepicker';
import { ko } from 'vuejs-datepicker/dist/locale';

// api
import Banner from '@/api/admin/banner/Banner.js';

// mixins
import { BannerMixin } from '@/mixins/admin/banner/Banner.js';

export default {
    name: 'AdminBannerCreate',
    mixins: [
        BannerMixin
    ],
    components: {
        Datepicker,
    },
    data() {
        return{
            id: '',
            data: {

            },
            ko: ko,
        };
    },
    created() {
        this.id = this.$route.params.id;
    },
    mounted() {
        this.getEditData();
    },
    methods: {
        nullCheck (value) {
            return value == '' || value == null || value == undefined || value == 'undefined';
        },
        dateFormat (date) {
            if (this.nullCheck(date)) {
                return '';
            }

            date = new Date(date);
            const year = date.getFullYear();
            let month = date.getMonth() + 1;
            let day = date.getDate();

            if (month < 10){
                month = `0${month}`;
            }

            if (day < 10) {
                day = `0${day}`;
            }

            return `${year}-${month}-${day}`;
        },
        getEditData() {
            Banner.getEditData(this.id).then(res => {
                const result = res.data.banner;

                this.position = result.position;
                this.order = result.order;
                this.title = result.title;
                this.link = result.link;
                this.is_open = result.is_open;
                this.started_at = result.started_at;
                this.ended_at = result.ended_at;
                this.desktop_file = result.desktop_file;
                this.desktop_file_id = result.desktop_file_id;
                this.mobile_file = result.mobile_file;
                this.mobile_file_id = result.mobile_file_id;
            });
        },
        update() {
            let data = {
                position : this.position,
                order : this.order,
                title : this.title,
                link : this.link,
                is_open : this.is_open,
                started_at : this.dateFormat(this.started_at),
                ended_at : this.dateFormat(this.ended_at),
                desktop_file : this.desktop_file,
                desktop_file_id : this.desktop_file.id,
                mobile_file : this.mobile_file,
                mobile_file_id : this.mobile_file.id
            };
            console.log(data);

                Banner.update(this.id, data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/banner');
            }).catch(err => {
                alert('오류');
            });
        },

    }
}
</script>

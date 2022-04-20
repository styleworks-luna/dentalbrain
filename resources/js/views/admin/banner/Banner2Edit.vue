<template>
    <layout title="배너수정" class="banner">
        <template v-slot:body>
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
            <single-group name="강의번호"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <input type="text" class="form-control" placeholder="강의번호를 입력해주세요."
                           v-model="program_id">
                    <p class="d-block mt-2">연결할 강의번호를 입력해 주세요.</p>
                </template>
            </single-group>

            <!-- 노출기간 -->
            <single-group name="노출기간"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content class="overflow-hidden">
                    <date-picker :time="started_at" @setTime="handleSetStartTime"></date-picker>
                    <span class="float-left mr-2 ml-2 d-block">~</span>
                    <date-picker :time="ended_at" @setTime="handleSetEndTime"></date-picker>
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
                <router-link :to="`/admin/banner2/${page}`"
                             class="btn btn-dark">취소
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// components
import Datepicker from 'vuejs-datepicker';
import {ko} from 'vuejs-datepicker/dist/locale';

// api
import Banner2 from '@/api/admin/banner/Banner2.js';

// mixins
import {BannerMixin, BannerCategoryMixin} from '@/mixins/admin/banner/Banner.js';

export default {
    name: 'AdminBanner2Create',
    mixins: [
        BannerMixin,
        BannerCategoryMixin
    ],
    components: {
        Datepicker,
    },
    data() {
        return {
            id: '',
            data: {},
            ko: ko,
            page: this.$route.params.page,
        };
    },
    created() {
        this.id = this.$route.params.id;
    },
    mounted() {
        this.getEditData();
    },
    methods: {
        getEditData() {
            Banner2.getEditData(this.id).then(res => {
                const result = res.data.banner;

                this.category_id = 5;
                this.order = result.order;

                this.title = result.title;
                this.program_id = result.program_id;

                this.started_at = result.started_at;
                this.ended_at = result.ended_at;

                this.is_open = result.is_open;
            });
        },
        update() {
            let data = {
                category_id: 5,
                order: this.order,

                title: this.title,
                program_id: this.program_id,

                started_at: this.Helper.dateFormatYDM(this.started_at),
                ended_at: this.Helper.dateFormatYDM(this.ended_at),

                is_open: this.is_open,
            };

            Banner2.update(this.id, data).then(res => {
                alert(res.data.msg);
                this.$router.push(`/admin/banner2/${this.page}`);
            }).catch(function (xhr) {
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

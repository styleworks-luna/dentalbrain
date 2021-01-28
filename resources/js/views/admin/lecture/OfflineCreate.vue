<template>
    <layout title="오프라인 강의 등록" id="lecture">
        <template v-slot:body>
            <div class="left-wrap">
                <thumbnail :id="'thumbnail'"
                           :file="thumbnail"
                           @setFile="handleSetThumbnail"></thumbnail>
            </div>
            <div class="right-wrap">
                <single-group name="분류 선택"
                              class="form-type"
                              :isRequired="true"
                              :isRow="true"
                              :size="9">
                    <template v-slot:content>
                        <select-box class="form-control mr-3"
                                    :text="'대분류'"
                                    :value="major_category_id"
                                    :options="majorCategoryOptions"
                                    @setValue="handleSetMajorCategoryId"></select-box>

                        <select-box class="form-control"
                                    :text="'소분류'"
                                    :value="minor_category_id"
                                    :options="minorCategoryOptions"
                                    @setValue="handleSetMinorCategoryId"></select-box>
                    </template>
                </single-group>

                <single-group name="제목 입력"
                              :isRow="true"
                              :isRequired="true"
                              :size="9">
                    <template v-slot:content>
                        <input type="text" class="form-control" placeholder="강의 제목을 입력해 주세요."
                               v-model="title">
                    </template>
                </single-group>

                <single-group name="강의 정보"
                              :isRow="true"
                              :isRequired="true"
                              :size="9">
                    <template v-slot:content>
                        <input type="text" class="form-control" placeholder="입력 예시) 유지관리 교육"
                               v-model="lecture_info">
                    </template>
                </single-group>
            </div>
            <single-group name="강의 일시" :isRow="true" :size="7">
                <template v-slot:content>
                    <div class="clearfix">
                        <date-picker class="mr-3" @setTime="handleSetStartDate"></date-picker>
                        <time-picker class="mr-3" @setTime="handleSetStartTime"></time-picker>
                        <p class="float-left mr-3 mt-2">부터</p>
                        <date-picker class="mr-3" @setTime="handleSetEndDate"></date-picker>
                        <time-picker @setTime="handleSetEndTime"></time-picker>
                    </div>
                </template>
            </single-group>

            <single-group name="강의 장소" :size="12">
                <template v-slot:content>
                    <naver-map></naver-map>
                </template>
            </single-group>

            <single-group name="신청일시" class="clearfix" :isRow="true" :size="9">
                <template v-slot:content>
                    <div class="float-left">
                        <label class="col-form-label d-block float-left" for="">모집정원</label>
                        <div class="col-md-9 float-left">
                            <input type="number" class="form-control" v-model="capacity">
                        </div>
                    </div>
                    <div class="float-left">
                        <label class="col-form-label d-block float-left mr-3" for="">신청기간</label>
                        <date-picker class="mr-3" @setTime="handleSetReciptStartDate"></date-picker>
                        <time-picker class="mr-3" @setTime="handleSetReciptStartTime"></time-picker>
                        <p class="float-left mr-3 mt-2">부터</p>
                        <date-picker class="mr-3" @setTime="handleSetReciptEndDate"></date-picker>
                        <time-picker @setTime="handleSetReciptEndTime"></time-picker>
                    </div>
                </template>
            </single-group>

            <single-group name="결제 정보 입력"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <div class="radio-wrap">
                        <input type="radio" id="pay" value="false"
                               v-model="is_free">
                        <label for="pay">유료</label>
                        <input type="number"
                               class="form-control ml-3"
                               placeholder="신청 금액 입력"
                               v-model="price">
                    </div>
                    <div class="radio-wrap mt-1">
                        <input type="radio" id="free" value="true"
                               v-model="is_free">
                        <label for="free">무료</label>
                    </div>
                </template>
            </single-group>

            <single-group name="상세정보입력" :size="12">
                <template v-slot:content>
                    <editor :content="content" @setEditor="handleSetEditor"></editor>
                </template>
            </single-group>

            <single-group name="추가정보" :size="12">
                <template v-slot:content>
                    <additional-information :data="surveys"></additional-information>
                </template>
            </single-group>


        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info" @click="create">등록</button>
                <router-link to="/admin/lecture/offline"
                             class="btn btn-dark">취소
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// components
import DatePicker from '@/components/common/DatePicker.vue'
import TimePicker from '@/components/common/TimePicker.vue'
import NaverMap from '@/components/common/NaverMap.vue';


import {LectureFormMixin} from '@/mixins/admin/lecture/Form.js';

export default {
    name: 'AdminOnlineCreate',
    mixins: [
        LectureFormMixin
    ],
    components: {
        'date-picker': DatePicker,
        'time-picker': TimePicker,
        'naver-map': NaverMap,
    },
    data() {
        return {
            started_date: '',
            started_time: '',
            ended_date: '',
            ended_time: '',
            capacity: '',
            receipt_started_date: '',
            receipt_started_time: '',
            receipt_ended_date: '',
            receipt_ended_time: '',
        }
    },
    computed: {},
    methods: {
        create() {
            let data = {
                thumbnail_id: this.thumbnail.id,
                major_category_id: this.major_category_id,
                minor_category_id: this.minor_category_id,
                title: this.title,
                lecture_info: this.lecture_info,
                is_free: this.is_free,
                price: this.price,
                content: this.content,
                surveys: this.surveys,
                ended_date: this.Helper.dateFormatYDM(this.ended_at),
                started_date: this.Helper.dateFormatYDM(this.started_at),
                started_time: this.started_time,
                ended_time: this.ended_time,
                receipt_started_date: this.Helper.dateFormatYDM(this.receipt_started_date),
                receipt_ended_date: this.Helper.dateFormatYDM(this.receipt_ended_date),
                receipt_started_time: this.receipt_started_time,
                receipt_ended_time: this.receipt_ended_time,
            };
            console.log(data);
            return false;
            Online.create(data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/lecture/online');
            }).catch(err => {
                alert('오류');
            });
        },
        handleSetStartDate(time) {
            this.started_at =  time;
        },
        handleSetStartTime(time) {
            this.started_time = time;
        },
        handleSetEndDate(time) {
            this.ended_at = time;
        },
        handleSetEndTime(time) {
            this.ended_time = time;
        },
        handleSetReciptStartDate(time) {
            this.receipt_started_date = time;
        },
        handleSetReciptStartTime(time) {
            this.receipt_started_time = time;
        },
        handleSetReciptEndDate(time) {
            this.receipt_ended_date = time;
        },
        handleSetReciptEndTime(time) {
            this.receipt_ended_time = time;
        },
    }

}

</script>

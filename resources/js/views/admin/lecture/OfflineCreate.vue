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
            <single-group name="강의 일시">
                <template v-slot:content class="overflow-hidden">
                    <date-picker @setTime="handleSetStartTime"></date-picker>
                    <time-picker></time-picker>
                    <p class="float-left">부터</p>
                    <date-picker @setTime="handleSetEndTime"></date-picker>
                    <time-picker></time-picker>
                </template>
            </single-group>

            <single-group name="강의 장소" :size="9">
                <template v-slot:content>
                    <naver-map></naver-map>
                </template>
            </single-group>

            <single-group name="신청일시" class="clearfix" :size="9">
                <template v-slot:content>
                    <div class="float-left">
                        <label class="col-form-label d-block float-left" for="">모집정원</label>
                        <div class="col-md-9 float-left">
                            <input type="number" class="form-control">
                        </div>
                    </div>
                    <div class="float-left">
                        <label class="col-form-label d-block float-left" for="">신청기간</label>
                        <date-picker @setTime=""></date-picker>
                        <time-picker></time-picker>
                        <p class="float-left">부터</p>
                        <date-picker></date-picker>
                        <time-picker></time-picker>
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
                               class="form-control"
                               placeholder="신청 금액 입력"
                               v-model="price">
                    </div>
                    <div class="radio-wrap">
                        <input type="radio" id="free" value="true"
                               v-model="is_free">
                        <label for="free">무료</label>
                    </div>
                </template>
            </single-group>

            <single-group name="상세정보입력">
                <template v-slot:content>
                    <editor></editor>
                </template>
            </single-group>

            <single-group name="추가정보">
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


import { LectureFormMixin } from '@/mixins/admin/lecture/Form.js';


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
            started_at: '',
            ended_at: '',
            receipt_started_at: '',
            receipt_ended_at: '',
        }
    },
    computed: {
    },
    methods: {
        create() {
            console.log(this.$data);
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

<template>
    <layout title="오프라인 강의 수정" class="offline">
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
                        <date-picker class="mr-3"
                                     :time="started_date"
                                     @setTime="handleSetStartDate"></date-picker>
                        <time-picker class="mr-3"
                                     :time="started_time"
                                     @setTime="handleSetStartTime"></time-picker>

                        <p class="float-left mr-3 mt-2">부터</p>

                        <date-picker class="mr-3"
                                     :time="ended_date"
                                     @setTime="handleSetEndDate"></date-picker>
                        <time-picker :time="ended_time"
                                     @setTime="handleSetEndTime"></time-picker>
                    </div>
                </template>
            </single-group>

            <single-group name="강의 장소" :size="12">
                <template v-slot:content>
                    <naver-map :data="program_place"
                               @setAddress="handleSetAddress"
                               @setAddressDetail="handleSetAddressDetail"
                               @setProgram="handleSetProgram"></naver-map>
                </template>
            </single-group>

            <single-group name="신청일시" class="clearfix" :isRow="true" :size="9">
                <template v-slot:content>
                    <div class="float-left">
                        <label class="col-form-label d-block float-left" for="">모집정원</label>
                        <div class="col-md-9 float-left">
                            <input type="text" class="form-control" v-model="program_place.capacity">
                        </div>
                    </div>
                    <div class="float-left">
                        <label class="col-form-label d-block float-left mr-3" for="">신청기간</label>
                        <date-picker class="mr-3"
                                     :time="receipt_started_date"
                                     @setTime="handleSetReceiptStartDate"></date-picker>
                        <time-picker class="mr-3"
                                     :time="receipt_started_time"
                                     @setTime="handleSetReceiptStartTime"></time-picker>

                        <p class="float-left mr-3 mt-2">부터</p>

                        <date-picker class="mr-3"
                                     :time="receipt_ended_date"
                                     @setTime="handleSetReceiptEndDate"></date-picker>
                        <time-picker :time="receipt_ended_time"
                                     @setTime="handleSetReceiptEndTime"></time-picker>
                    </div>
                </template>
            </single-group>

            <div :class="haveStudents ? 'bg-light text-dark':''">
            <single-group name="결제 정보 입력"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <div>
                        <div class="radio-wrap">
                            <input type="radio" id="pay" value="0"
                                   :disabled="haveStudents == true"
                                   v-model="is_free">
                            <label for="pay">유료</label>
                            <input type="text"
                                   class="form-control ml-3"
                                   placeholder="신청 금액 입력"
                                   :disabled="is_free == 1 || haveStudents == true"
                                   v-model="price">
                        </div>
                        <div class="radio-wrap mt-1">
                            <input type="radio" id="free" value="1"
                                   :disabled="haveStudents == true"
                                   v-model="is_free">
                            <label for="free">무료</label>
                        </div>
                    </div>
                </template>
            </single-group>
            </div>

            <single-group name="상세정보입력" :size="12">
                <template v-slot:content>
                    <editor :content="content" @setEditor="handleSetEditor"></editor>
                </template>
            </single-group>

            <div :class="haveStudents ? 'bg-light text-dark':''">
            <single-group name="추가정보" :size="12">
                <template v-slot:content>
                    <additional-information :data="surveys" :haveStudentValue="haveStudents"></additional-information>
                </template>
            </single-group>
            </div>

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
                <button type="button" class="btn btn-info" @click="update">수정</button>
                <router-link to="/admin/lecture/offline"
                             class="btn btn-dark">취소
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
//api
import { Offline } from '@/api/admin/lecture/Offline.js'

//mixins
import {LectureFormMixin, ProgramCategoryMixin} from '@/mixins/admin/lecture/Form.js';
import {OfflineMixin} from '@/mixins/admin/lecture/Offline.js';

export default {
    name: 'AdminOfflineEdit',
    mixins: [
        LectureFormMixin,
        ProgramCategoryMixin,
        OfflineMixin
    ],
    created() {
        this.id = this.$route.params.id;
    },
    mounted() {
        this.getEditData();
    },
    methods: {
        getEditData() {
            Offline.getEditData(this.id).then(res => {
                const program = res.data.program;
                const ticket = res.data.ticket;

                this.thumbnail = program.thumbnail;

                this.major_category_id = program.major_category_id;
                this.minor_category_id = program.minor_category_id;
                this.title = program.title;

                this.lecture_info = ticket.name;
                this.is_free = ticket.is_free;
                this.price = ticket.price;

                this.content = program.content;

                this.surveys = res.data.surveys;

                this.is_open = program.is_open;
                this.program_place = res.data.place;

                this.started_date = this.Helper.dateFullFormat(this.program_place.started_at);
                this.started_time = this.Helper.timeFormat(this.started_date);
                this.ended_date = this.Helper.dateFullFormat(this.program_place.ended_at);
                this.ended_time = this.Helper.timeFormat(this.ended_date);
                this.receipt_started_date = this.Helper.dateFullFormat(this.program_place.receipt_started_at);
                this.receipt_started_time = this.Helper.timeFormat(this.receipt_started_date);
                this.receipt_ended_date = this.Helper.dateFullFormat(this.program_place.receipt_ended_at);
                this.receipt_ended_time = this.Helper.timeFormat(this.receipt_ended_date);

                this.haveStudents = res.data.haveStudents;
            });
        },
        update() {
            const started_at = `${this.Helper.dateFormatYDM(this.started_date)} ${this.started_time}`;
            const ended_at = `${this.Helper.dateFormatYDM(this.ended_date)} ${this.ended_time}`;
            const receipt_started_at = `${this.Helper.dateFormatYDM(this.receipt_started_date)} ${this.receipt_started_time}`;
            const receipt_ended_at = `${this.Helper.dateFormatYDM(this.receipt_ended_date)} ${this.receipt_ended_time}`;

            this.program_place.started_at = started_at;
            this.program_place.ended_at = ended_at;
            this.program_place.receipt_started_at = receipt_started_at;
            this.program_place.receipt_ended_at = receipt_ended_at;

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

                is_open: this.is_open,
                program_place: this.program_place
            };

            Offline.update(this.id, data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/lecture/offline');
            })
        }
    }
}

</script>

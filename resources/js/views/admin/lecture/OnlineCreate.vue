<template>
    <layout title="온라인 강의 등록" class="online">
        <template v-slot:body>
            <!-- 제목 -->
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

                <single-group name="강의 시간"
                              :isRow="true"
                              :isRequired="true"
                              :size="9">
                    <template v-slot:content>
                        <input type="text" class="form-control" placeholder="입력 예시) 총 10강. 총 2시간 30분"
                               v-model="running_time">
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

            <single-group name="상세 정보 입력" :isRequired="true" :size="12">
                <template v-slot:content>
                    <editor :content="content" @setEditor="handleSetEditor"></editor>
                </template>
            </single-group>

            <single-group name="결제 정보 입력"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <div class="radio-wrap">
                        <input type="radio" id="pay" :value="false"
                               v-model="is_free">
                        <label for="pay" class="mr-3">유료</label>
                        <input type="text"
                               class="form-control"
                               placeholder="신청 금액 입력"
                               :disabled="is_free == true"
                               v-model="price">
                    </div>
                    <div class="radio-wrap free">
                        <input type="radio" id="free" :value="true"
                               v-model="is_free">
                        <label for="free">무료</label>
                    </div>
                </template>
            </single-group>


            <single-group name="추가 정보"
                          :size="12">
                <template v-slot:content>
                    <additional-information :data="surveys"></additional-information>
                </template>
            </single-group>

            <single-group name="강의 설정"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <div class="lecture-setting" v-for="(lecture, index) in lectures">
                        <div class="form-group row">
                            <label class="col-form-label" for="">강의제목</label>
                            <span class="text-danger mt-2 ml-2">*</span>
                            <div class="col-md-9">
                                <input type="text" class="form-control lecture-title" v-model="lecture.title">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label" for="">유튜브 링크</label>
                            <span class="text-danger mt-2 ml-2">*</span>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="lecture.url">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label float-left mr-4" for="">썸네일 등록</label>
                            <file-upload :inputId="'lecture_file' + index"
                                         :initFile="lecture.thumbnail"
                                         :index="index"
                                         @setFile="updateLectureFile"></file-upload>
                        </div>
                    </div>

                    <button class="btn btn-outline-dark w-100" @click="addLecture">강의 추가</button>
                </template>
            </single-group>

            <single-group name="강의 자료"
                          :isRow="true"
                          :size="9">
                <template v-slot:content>
                    <div class="lecture-file-wrap">
                        <file-upload :inputId="'file'"
                                     :initFile="material"
                                     @setFile="updateFile"></file-upload>
                    </div>
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
                <button type="submit" class="btn btn-info" @click="create">등록</button>
                <router-link to="/admin/lecture/online"
                             class="btn btn-dark">취소
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// mixin
import {LectureFormMixin, ProgramCategoryMixin} from '@/mixins/admin/lecture/Form.js';
import {OnlineMixin} from '@/mixins/admin/lecture/Online.js';

//api
import { Online } from '@/api/admin/lecture/Online.js'

export default {
    name: 'AdminOnlineCreate',
    mixins: [
        LectureFormMixin,
        ProgramCategoryMixin,
        OnlineMixin
    ],
    methods: {
        create() {
            let lectures = [];

            this.lectures.forEach(lecture => {
                lectures.push({
                    title: lecture.title,
                    url: lecture.url,
                    thumbnail_id: Object.keys(lecture.thumbnail).length > 0 ? lecture.thumbnail.id : null
                })
            });

            let data = {
                major_category_id: this.major_category_id,
                minor_category_id: this.minor_category_id,

                thumbnail_id: this.thumbnail ? this.thumbnail.id : null,
                title: this.title,
                running_time: this.running_time,

                lecture_info: this.lecture_info,
                price: this.price,
                is_free: this.is_free,
                is_open: this.is_open,

                content: this.content,

                material_id: this.material ? this.material.id : null,

                surveys: this.surveys,
                lectures: lectures
            };

            Online.create(data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/lecture/online');
            })
        },
    }
}
</script>

<template>
    <layout title="온라인 강의 복사" class="online">
        <template v-slot:body>
            <!-- 제목 -->
            <div class="left-wrap">
                <thumbnail :id="'thumbnail'"
                           :file="thumbnail"
                           @setFile="handleSetThumbnail"></thumbnail>
            </div>

            <div class="right-wrap">
                <single-group name="증명서 선택"
                              class="form-type"
                              :isRow="true"
                              :size="9">
                    <template v-slot:content>
                        <select-box class="form-control mr-3"
                                    :text="'자격증 선택'"
                                    :value="certification_id"
                                    :options="certificationOptions"
                                    @setValue="handleSetCertificateCategoryId"></select-box>

                        <select-box class="form-control"
                                    :text="'수료증 선택'"
                                    :value="completion_id"
                                    :options="completionOptions"
                                    @setValue="handleSetCompletionCategoryId"></select-box>
                    </template>
                </single-group>
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

                <single-group name="수강기한"
                              :isRow="true"
                              :isRequired="true"
                              :size="2">
                    <template v-slot:content>
                        <input type="text" class="form-control" placeholder="일수"
                               v-model="term">
                    </template>
                </single-group>
            </div>

            <single-group name="상세 정보 입력" :isRequired="true" :size="12">
                <template v-slot:content>
                    <editor :content="content" :uploadImageUrl="`/api/admin/lecture/upload`" @setEditor="handleSetEditor"></editor>
                </template>
            </single-group>

            <div>
                <single-group name="결제 정보 입력"
                              :isRow="true"
                              :isRequired="true"
                              :size="9">
                    <template v-slot:content>

                        <div class="price overflow-hidden">
                            <label class="col-form-label d-block float-left mr-3">일반회원가</label>
                            <div class="radio-wrap mt-1" style="margin-right: 5px">
                                <input type="radio" id="free" :value="true"
                                       v-model="is_free">
                                <label for="free">무료</label>
                            </div>
                            <div class="radio-wrap">
                                <input type="radio" id="pay" :value="false"
                                       v-model="is_free">
                                <label for="pay">유료</label>
                                <input type="text"
                                       class="form-control ml-2"
                                       placeholder="신청 금액 입력"
                                       :disabled="is_free == true"
                                       style="width: 120px; margin-right: 10px"
                                       v-model="price">
                                <input type="checkbox" id="discount"
                                       :disabled="is_free == true"
                                       v-model="is_discount">
                                <label for="discount" style="margin-right: 10px">할인 : </label>
                                <label>할인율</label>
                                <input type="text"
                                       class="form-control ml-2"
                                       :disabled="is_discount == false || is_free == true"
                                       style="width: 50px; margin-right: 5px;"
                                       v-model="discount_rate">
                                <span style="margin-right: 15px;">%</span>
                                <label>할인가</label>
                                <input type="text"
                                       class="form-control ml-2"
                                       placeholder="신청 금액 입력"
                                       :disabled="is_discount == false || is_free == true"
                                       style="width: 120px;"
                                       v-model="discounted_price">
                            </div>
                        </div>
                        <div class="membership-price overflow-hidden mt-3">
                            <label class="col-form-label d-block float-left mr-3">유료회원가</label>
                            <div class="radio-wrap mt-1" style="margin-right: 5px">
                                <input type="radio" id="membership_free" :value="true"
                                       v-model="membership_is_free">
                                <label for="membership_free">무료</label>
                            </div>
                            <div class="radio-wrap">
                                <input type="radio" id="membership_pay" :value="false"
                                       v-model="membership_is_free">
                                <label for="membership_pay">유료</label>
                                <input type="text"
                                       class="form-control ml-2"
                                       placeholder="신청 금액 입력"
                                       :disabled="membership_is_free == true"
                                       style="width: 120px; margin-right: 10px"
                                       v-model="membership_price">
                                <input type="checkbox" id="membership_discount"
                                       :disabled="membership_is_free == true"
                                       v-model="membership_is_discount">
                                <label for="discount" style="margin-right: 10px">할인 : </label>
                                <label>할인율</label>
                                <input type="text"
                                       class="form-control ml-2"
                                       :disabled="membership_is_discount == false || membership_is_free == true"
                                       style="width: 50px; margin-right: 5px;"
                                       v-model="membership_discount_rate">
                                <span style="margin-right: 15px;">%</span>
                                <label>할인가</label>
                                <input type="text"
                                       class="form-control ml-2"
                                       placeholder="신청 금액 입력"
                                       v-model="membership_discounted_price"
                                       :disabled="membership_is_discount == false || membership_is_free == true"
                                       style="width: 120px;">
                            </div>
                        </div>

                    </template>
                </single-group>
            </div>


            <single-group name="추가 정보"
                          :size="12">
                <template v-slot:content>
                    <additional-information :data="surveys"></additional-information>
                </template>
            </single-group>

            <single-group name="미리보기 설정"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <div class="lecture-setting">
                        <div class="form-group row">
                            <label class="col-form-label">
                                <select-box class="form-control"
                                            :value="preview_type"
                                            :options="VideoOptions"
                                            @setValue="handleSetPreview"></select-box>
                            </label>
                            <span class="text-danger mt-2 ml-2">*</span>
                            <div class="col-md-9 mt-2">
                                <input type="text" class="form-control" v-model="preview_url">
                            </div>
                        </div>
                    </div>
                </template>
            </single-group>


            <single-group name="강의 설정"
                          :isRow="true"
                          :size="9">
                <template v-slot:content>

                    <div class="lecture-setting" v-for="(lecture, index) in lectures" :key="lecture.id">
                        <div class="form-group row">
                            <label class="col-form-label" for="">강의제목</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control lecture-title" v-model="lecture.title">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label" for="">
                                <select-box class="form-control"
                                     :value="lecture.video_type"
                                     :options="VideoOptions"
                                     :index="index"
                                     @setValue="handleSetVideo"></select-box>
                            </label>
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
                        <div class="btn-wrap">
                            <button class="btn btn-outline-dark" @click.prevent="removeLecture(index)">강의 삭제</button>
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
                    <a class="btn-download" v-bind:href="material.url" download>{{material.name}}</a>
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
                <button class="btn btn-primary" @click="duplicate">복사</button>
                <router-link :to="`/admin/lecture/online/${page}`"
                             class="btn btn-dark">취소
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// mixins
import {LectureFormMixin, ProgramCategoryMixin} from '@/mixins/admin/lecture/Form.js';
import {OnlineMixin} from '@/mixins/admin/lecture/Online.js';

// api
import {Online} from '@/api/admin/lecture/Online.js'


export default {
    name: 'AdminOnlineEdit',
    mixins: [
        LectureFormMixin,
        ProgramCategoryMixin,
        OnlineMixin
    ],
    data() {
        return {
            id: '',
            data: {},
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
            Online.getEditData(this.id).then(res => {
                const program = res.data.program;

                this.major_category_id = program.major_category_id;
                this.minor_category_id = program.minor_category_id;

                this.certification_id = program.qualification_id;
                this.completion_id = program.completion_id;

                this.thumbnail = program.thumbnail;

                this.title = program.title;
                this.running_time = program.running_time;

                this.content = program.content;

                this.material = program.material;

                this.is_open = program.is_open;

                this.lecture_info = program.description;
                this.term = program.term;

                this.preview_url = program.preview_url;
                this.preview_type = program.preview_type;

                this.is_discount = program.is_discount == 1 ? true : false;
                this.membership_is_discount = program.membership_is_discount == 1 ? true : false;

                this.is_free = program.is_free == 1 ? true : false;
                this.price = program.price;

                this.discounted_price = program.discounted_price;
                this.discount_rate = program.discount_rate;

                this.membership_discounted_price = program.membership_discounted_price;
                this.membership_discount_rate = program.membership_discount_rate;

                this.membership_is_free = program.membership_is_free == 1 ? true : false;
                this.membership_price = program.membership_price;


                this.surveys = res.data.surveys;

                this.lectures = res.data.lectures;
            });
        },
        duplicate() {
            let lectures = [];

            this.lectures.forEach(lecture => {
                lectures.push({
                    id: lecture.id,
                    title: lecture.title,
                    url: lecture.url,
                    video_type: lecture.video_type,
                    thumbnail_id: lecture.thumbnail ? lecture.thumbnail.id : null
                });
            });

            let data = {
                qualification_id: this.certification_id,
                completion_id: this.completion_id,
                major_category_id: this.major_category_id,
                minor_category_id: this.minor_category_id,

                thumbnail_id: this.thumbnail ? this.thumbnail.id : null,
                title: this.title,
                running_time: this.running_time,

                lecture_info: this.lecture_info,
                term: this.term,
                price: this.price,

                is_discount: this.is_discount,
                membership_is_discount: this.membership_is_discount,

                is_free: this.is_free,
                is_open: this.is_open,

                preview_url: this.preview_url,
                preview_type: this.preview_type,

                discounted_price: this.discounted_price,
                discount_rate: this.discount_rate,

                membership_is_free: this.membership_is_free,
                membership_price: this.membership_price,
                membership_discounted_price: this.membership_discounted_price,
                membership_discount_rate: this.membership_discount_rate,

                content: this.content,

                material_id: this.material ? this.material.id : null,

                surveys: this.surveys,
                lectures: lectures,
            };

            Online.duplicate(this.id,data).then(res => {
                alert(res.data.msg);
                this.$router.push(`/admin/lecture/online/1`);
            })
        }
    }
}
</script>

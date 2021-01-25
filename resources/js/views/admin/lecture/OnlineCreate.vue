<template>
    <layout title="온라인 강의 등록" id="lecture">
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
                        <select-box class="form-control"
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

            <single-group name="상세 정보 입력" :isRequired="true" :size="10">
                <template v-slot:content>
                    <textarea class="form-control" rows="9" placeholder="내용"
                              v-model="description"></textarea>
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

            <single-group name="강의 일시">
                <template v-slot:content class="overflow-hidden">
                    <date-picker></date-picker>
                    <time-picker></time-picker>
                    <p class="float-left">부터</p>
                    <date-picker></date-picker>
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
                        <input  type="number" class="form-control">
                        </div>
                    </div>
                    <div class="float-left">
                        <label class="col-form-label d-block float-left" for="">신청기간</label>
                        <date-picker></date-picker>
                        <time-picker></time-picker>
                        <p class="float-left">부터</p>
                        <date-picker></date-picker>
                        <time-picker></time-picker>
                    </div>
                </template>
            </single-group>

            <single-group name="상세정보입력">
                <template v-slot:content>
                    <editor></editor>
                </template>
            </single-group>

            <single-group name="추가 정보"
                          :size="9">
                <template v-slot:content>
                </template>
            </single-group>

            <single-group name="강의 설정"
                          :isRow="true"
                          :size="9">
                <template v-slot:content>
                    <div class="lecture-setting" v-for="lecture in lectures">
                        <div class="form-group row">
                            <label class="col-form-label" for="">강의제목</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="lecture.title">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label" for="">유튜브 링크</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" v-model="lecture.link">
                            </div>
                        </div>

                        <div class="form-group">
                            <image-upload></image-upload>
                        </div>
                    </div>

                    <button class="btn btn-outline-dark w-100" @click="addLecture">강의 추가</button>
                </template>
            </single-group>

            <single-group name="강의 자료"
                          :isRow="true"
                          :size="9">
                <template v-slot:content>
                    <input type="file">
                </template>
            </single-group>
        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info" @click="create">등록</button>
                <router-link to="/admin/lecture/online"
                             class="btn btn-dark">취소</router-link>
            </div>
        </template>
    </layout>
</template>

<script>
    // component
    import SingleGroup from '@/components/admin/form/SingleGroup.vue';
    import Thumbnail from '@/components/admin/form/Thumbnail.vue';
    import SelectBox from '@/components/common/SelectBox.vue';
    import NaverMap from '@/components/common/NaverMap.vue';
    import Editor from '@/components/common/Editor.vue';
    import ImageUpload from '@/components/common/ImageUpload.vue';
    import DatePicker from '@/components/common/DatePicker.vue'
    import TimePicker from '@/components/common/TimePicker.vue'

    export default {
        name: 'AdminOnlineCreate',
        components: {
            'single-group': SingleGroup,
            'thumbnail': Thumbnail,
            'select-box': SelectBox,
            'naver-map': NaverMap,
            'editor': Editor,
            'image-upload': ImageUpload,
            'date-picker': DatePicker,
            'time-picker': TimePicker,
        },
        data() {
            return {
                thumbnail: {},
                major_category_id: '',
                minor_category_id: '',
                title: '',
                running_time: '',
                lecture_info: '',
                description: '',
                is_free: true,
                price: '',
                file: {},
                lectures: [
                    {
                        title: '',
                        link: '',
                    }
                ]
            }
        },
        computed: {
            majorCategoryOptions() {

            },
            minorCategoryOptions() {

            },

        },
        methods: {
            create() {
                console.log(this.$data);
            },
            handleSetThumbnail(file) {
                this.thumbnail = file;
            },
            handleSetFile(file) {
                this.file = file;
            },
            handleSetMajorCategoryId(id) {
                this.major_category_id = id;
            },
            handleSetMinorCategoryId(id) {
                this.minor_category_id = id;
            },
            addLecture() {
                this.lectures.push({
                    title: '',
                    link: ''
                })
            }
        }
    }
</script>

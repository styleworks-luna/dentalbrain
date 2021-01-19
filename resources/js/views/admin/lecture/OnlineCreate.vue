<template>
    <layout title="온라인 강의 등록" id="lecture">
        <template v-slot:body>
            <!-- 제목 -->
            <div class="left-wrap">
                <thumbnail :id="'thumbnail'"
                           :file="thumbnail"
                           @setFile="handleSetFile"></thumbnail>
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
                                    :value="category_id"
                                    :options="categoryOptions"
                                    @setValue="handleSetCategoryId"></select-box>

                        <select-box class="form-control"
                                    :text="'소분류'"
                                    :value="category_id"
                                    :options="categoryOptions"
                                    @setValue="handleSetCategoryId"></select-box>
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
                               v-model="title">
                    </template>
                </single-group>

                <single-group name="강의 정보"
                              :isRow="true"
                              :isRequired="true"
                              :size="9">
                    <template v-slot:content>
                        <input type="text" class="form-control" placeholder="입력 예시) 유지관리 교육"
                               v-model="title">
                    </template>
                </single-group>
            </div>

            <single-group name="상세 정보 입력" :isRequired="true" :size="9">
                <template v-slot:content>
                    <textarea></textarea>
                </template>
            </single-group>

            <single-group name="결제 정보 입력"
                          :isRow="true"
                          :isRequired="true"
                          :size="9">
                <template v-slot:content>
                    <div class="radio-wrap">
                        <input type="radio">
                        <label for="">유료</label>
                        <input type="text" class="form-control" placeholder="신청 금액 입력"
                               v-model="title">
                    </div>
                    <div class="radio-wrap">
                        <input type="radio">
                        <label for="">무료</label>
                    </div>
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
                    <div class="lecture-setting">
                        <div class="form-group row">
                            <label class="col-form-label" for="">asdasd</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label" for="">asdasd</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label" for="">asdasd</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control">
                            </div>
                        </div>
                    </div>

                    <button>강의 추가</button>
                </template>
            </single-group>

            <single-group name="강의 자료"
                          isRow="true"
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

    export default {
        name: 'AdminOnlineCreate',
        components: {
            'single-group': SingleGroup,
            'thumbnail': Thumbnail,
            'select-box': SelectBox
        },
        data() {
            return {
                data: {
                    thumbnail: {},
                    major_category_id: '',
                    minor_category_id: '',
                    title: '',
                    file: {},
                }
            }
        },
        methods: {
            create() {
                console.log(this.$data);
            },
            handleSetFile(file) {
                this.file = file
            }
        }
    }
</script>

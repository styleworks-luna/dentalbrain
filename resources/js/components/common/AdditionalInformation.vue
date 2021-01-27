<template>
    <div class="additional-information w-100">
        <div class="menu-wrap">
            <button class="btn btn-ghost-dark d-block"
                    @click="addChoice('singleChoice')">객관식 (단일선택)
            </button>
            <button class="btn btn-ghost-dark d-block"
                    @click="addChoice('multipleChoice')">객관식 (다중선택)
            </button>
            <button class="btn btn-ghost-dark d-block"
                    @click="addquestion('shortAnswer')">주관식
            </button>
            <button class="btn btn-ghost-dark d-block"
                    @click="addquestion('address')">주소검색
            </button>
            <button class="btn btn-ghost-dark d-block"
                    @click="addquestion('file')">파일첨부
            </button>
        </div>
        <div class="survey-wrap">
            <div v-for="(survey, index) in surveys">

                <!-- 객관식 단일 -->
                <div class="form-wrap" v-if="survey.type == 'singleChoice'">
                    <div class="input-wrap">
                        <input type="text"
                               class="form-control"
                               v-model="survey.question"
                               placeholder="객관식 (단일선택) 질문을 입력해주세요.">
                        <div class="item-wrap" v-for="(item, idx) in survey.choices">
                            <span class="circle"></span>
                            <input type="text"
                                   class="form-control choices"
                                   v-model="surveys[index].choices[idx]"
                                   placeholder="항목을 입력해주세요.">
                            <button class="btn btn-outline-dark btn-item-delete"
                                    @click="popItem(survey.choices,idx)">항목삭제
                            </button>
                        </div>
                    </div>
                    <div class="checkbox-wrap">
                        <input type="checkbox" :id="'required' + index" v-model="survey.is_required">
                        <label :for="'required'+ index">필수입력</label>
                    </div>
                    <div class="btn-wrap">
                        <button class="btn btn-outline-dark" @click="addItem(index)">항목추가</button>
                        <button class="btn btn-outline-dark" @click="pop(surveys,index)">질문삭제</button>
                    </div>
                </div>

                <!-- 객관식 다중 -->
                <div class="form-wrap" v-if="survey.type == 'multipleChoice'">
                    <div class="input-wrap">
                        <input type="text"
                               class="form-control"
                               v-model="survey.question"
                               placeholder="객관식 (다중선택) 질문을 입력해주세요.">
                        <div class="item-wrap" v-for="(item, idx) in survey.choices">
                            <span class="square"></span>
                            <input type="text"
                                   class="form-control choices"
                                   v-model="surveys[index].choices[idx]"
                                   placeholder="항목을 입력해주세요.">
                            <button class="btn btn-outline-dark btn-item-delete"
                                    @click="popItem(survey.choices,idx)">항목삭제
                            </button>
                        </div>
                    </div>
                    <div class="checkbox-wrap">
                        <input type="checkbox" :id="'required' + index" v-model="survey.is_required">
                        <label :for="'required'+ index">필수입력</label>
                    </div>
                    <div class="btn-wrap">
                        <button class="btn btn-outline-dark" @click="addItem(index)">항목추가</button>
                        <button class="btn btn-outline-dark" @click="pop(surveys,index)">질문삭제</button>
                    </div>
                </div>

                <!-- 주관식 단답 -->
                <div class="form-wrap" v-if="survey.type =='shortAnswer'">
                    <div class="input-wrap">
                        <input type="text"
                               class="form-control"
                               v-model="survey.question"
                               placeholder="주관식 질문을 입력해주세요.">
                    </div>
                    <div class="checkbox-wrap">
                        <input type="checkbox" :id="'required' + index" v-model="survey.is_required">
                        <label :for="'required'+ index">필수입력</label>
                    </div>
                    <div class="btn-wrap">
                        <button class="btn btn-outline-dark" @click="pop(surveys,index)">질문삭제</button>
                    </div>
                </div>

                <!-- 주소질문 -->
                <div class="form-wrap" v-if="survey.type == 'address'">
                    <div class="input-wrap">
                        <input type="text"
                               class="form-control"
                               v-model="survey.question"
                               placeholder="주소 질문을 입력해주세요.">
                    </div>
                    <div class="checkbox-wrap">
                        <input type="checkbox" :id="'required' + index" v-model="survey.is_required">
                        <label :for="'required'+ index">필수입력</label>
                    </div>
                    <div class="btn-wrap">
                        <button class="btn btn-outline-dark" @click="pop(surveys,index)">질문삭제</button>
                    </div>
                </div>

                <!-- 파일첨부 -->
                <div class="form-wrap" v-if="survey.type == 'file'">
                    <div class="input-wrap">
                        <input type="text"
                               class="form-control"
                               v-model="survey.question"
                               placeholder="파일첨부 질문을 입력해주세요.">
                    </div>
                    <div class="checkbox-wrap">
                        <input type="checkbox" :id="'required' + index" v-model="survey.is_required">
                        <label :for="'required'+ index">필수입력</label>
                    </div>
                    <div class="btn-wrap">
                        <button class="btn btn-outline-dark" @click="pop(surveys,index)">질문삭제</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>

export default {
    name: 'AdditionalInformation',
    data() {
        return {
            surveys: [],
        }
    },
    props:{
        'data': [Array],
    },
    mounted() {
        this.surveys = this.data;
    },
    methods: {
        addChoice(type) {
            this.surveys.push(
                {
                    type: type,
                    question: '',
                    is_required: 0,
                    choices: [],
                }
            )
        },
        addquestion(type) {
            this.surveys.push(
                {
                    type: type,
                    question: '',
                    is_required: 0,
                }
            )
        },
        addItem(index) {
            this.surveys[index].choices.push('');
        },
        pop(data, index) {
            data.splice(index, 1)
        },
        popItem(data, index) {
            data.splice(index, 1)
        }
    },
}
</script>

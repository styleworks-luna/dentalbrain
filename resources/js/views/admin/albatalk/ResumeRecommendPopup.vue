<template>
    <div class="popup-container">
        <div class="layer" @click="controlPopup"></div>
        <article class="popup-wrap">
            <header class="popup-header border-bottom d-flex justify-content-between">
                <h2 class="popup-title">추천하기</h2>
                <button class="btn btn-secondary mb-2" @click="controlPopup">닫기</button>
            </header>

            <section class="popup-content">
                <div class="d-flex justify-content-start">
                    <div class="w-50 border-right">
                        <h5 class="text-center">추천하기</h5>
                        <ul class="pl-4 pt-2 pb-5" style="list-style: none;">
                            <li v-for="item in recommendList" :key="item.id">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" :id="`inlineCheckbox_${item.id}`"
                                           :value="item.id" v-model="applies">
                                    <label class="form-check-label"
                                           :for="`inlineCheckbox_${item.id}`">{{ item.company_name }}</label>
                                </div>
                            </li>
                            <li v-if="recommendList.length <= 0">
                                <p>추천할 내역이 없습니다.</p>
                            </li>
                        </ul>

                    </div>
                    <div class="w-50">
                        <h5 class="text-center">추천 취소하기</h5>
                        <ul class="pl-4  pt-2 pb-5" style="list-style: none;">
                            <li v-for="item in cancelList" :key="item.id">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" :id="`inlineCheckbox_${item.id}`"
                                           :value="item.id" v-model="cancels">
                                    <label class="form-check-label"
                                           :for="`inlineCheckbox_${item.id}`">{{ item.company_name }}</label>
                                </div>
                            </li>
                            <li v-if="cancelList.length <= 0">
                                <p>취소할 내역이 없습니다.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <article class="btn-area d-flex justify-content-center">
                <div class="btn-wrap w-50 text-center">
                    <button class="btn btn-info " @click.prevent="apply">제출</button>
                </div>
                <div class="btn-wrap w-50 text-center">
                    <button class="btn btn-danger" @click.prevent="cancel">취소</button>
                </div>
            </article>
        </article>
    </div>
</template>

<script>
// api
import RecommendData from "@/api/admin/albatalk/Resume.js"

export default {
    name: "ResumeRecommendPopup",
    props: {
        id: Number,
    },
    mounted() {
        this.getRecommendData();
    },
    data() {
        return {
            recommendList: [],
            cancelList: [],
            applies: [],
            cancels: []
        }
    },
    methods: {
        getRecommendData() {
            RecommendData.getRecommendData(this.id).then(res => {
                this.recommendList = res.data.applyList;
                this.cancelList = res.data.cancelList;
            }).catch(err => {
                alert('오류가 발생하였습니다.');
            });
        },
        apply() {
            if(this.recommendList.length <= 0) {
                alert('추천할 내역이 없습니다.');
            } else {
                if(this.applies.length <= 0) {
                    alert('추천할 구인정보를 선택해주세요.');
                }
                else {
                    let data = {
                        recruits: this.applies,
                    }
                    RecommendData.recommendApply(this.id, data).then(res => {
                        alert(res.data.msg);
                        this.$emit('close', false);
                    }).catch(err => {
                        alert('오류가 발생하였습니다.');
                    });
                }
            }

        },
        cancel() {
            if(this.cancelList.length <= 0) {
                alert('취소할 내역이 없습니다.');
            } else {
                if(this.cancels.length <= 0) {
                    alert('취소할 구인정보를 선택해주세요.');
                }
                else {
                    let data = {
                        recruits: this.cancels,
                    }
                    RecommendData.recommendCancel(this.id, data).then(res => {
                        alert(res.data.msg);
                        this.$emit('close', false);
                    }).catch(err => {
                        alert('오류가 발생하였습니다.');
                    });
                }
            }
        },
        controlPopup() {
            this.$emit('close', false);
        }
    }
}
</script>

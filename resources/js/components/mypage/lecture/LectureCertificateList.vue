<template>
    <div class="mypage-certificateList">
        <div class="mypage-content">
            <ul>
                <li v-for="lecture in lectures" :key="lecture.id">
                    <div class="content-information-wrap">
                        <figure class="content-image">
                            <a :href="'/lectures/' + lecture.program_id">
                                <img :src="lecture.thumbnail_url" alt="강의사진">
                                <template v-if="lecture.programs_completion_id && lecture.programs_qualification_id">
                                    <div class="certificate-mark">수료/자격증</div>
                                </template>
                                <template v-else-if="lecture.programs_completion_id">
                                    <div class="certificate-mark">수료증</div>
                                </template>
                                <template v-else-if="lecture.programs_qualification_id">
                                    <div class="certificate-mark">자격증</div>
                                </template>
                            </a>
                        </figure>
                        <div class="content-information">
                            <div class="lecture-sort">
                                <span class="lecture-type">{{ lecture.programs_minor_category_name }}</span>

                                <p class="lecture-date" v-if="lecture.programs_minor_category_name!='스토어'">
                                    <template v-if="lecture.programs_is_online==true">수강기간 {{ lecture.programs_term }}일</template>
                                </p>
                            </div>
                            <h3 class="lecture-title">
                                <a :href="'/lectures/' + lecture.program_id">{{ lecture.programs_title }}</a>
                            </h3>
                            <table v-if="lecture.programs_is_online">
                                <tr>
                                    <th>강의시간</th>
                                    <td><p class="lecture-length">{{ lecture.programs_running_time }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제금액</th>
                                    <td>
                                        <p class="lecture-pay">
                                            {{
                                                lecture.payments_totalAmount == null ? '무료' :
                                                    Helper.numberWithCommas(lecture.payments_totalAmount) + '원'
                                            }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            <table v-else>
                                <tr>
                                    <th>강의일시</th>
                                    <td>
                                        <p class="lecture-length">
                                            {{ `${lecture.places_started_at} ~ ${lecture.places_ended_at}`  }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>강의장소</th>
                                    <td>
                                        <p class="lecture-length lecture-place">
                                            {{ `${ lecture.places_address } ${lecture.places_address_detail}` }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                    </div>
                    </div>
                    <div class="lecture-under">
                        <div class="btn-zone" :class="(lecture.programs_qualification_id != null && lecture.programs_completion_id  != null) ? ''  : 'btn-zone-one'">
                            <template v-if="lecture.qualification_profiles_is_issued == 0">
                                <template v-if="lecture.programs_completion_id != null"><button class="btn-lecture fail" disabled>수료증 대기중</button></template>
                                <template v-if="lecture.programs_qualification_id != null"><button class="btn-lecture fail" disabled>자격증 대기중</button></template>
                            </template>
                            <template v-else>
                                <template v-if="lecture.programs_qualification_id != null">
                                    <template v-if="lecture.qualification_status == 2"><button class="btn-lecture fail" disabled>자격증 대기중</button></template>
                                    <template v-if="lecture.qualification_status == 3"><button class="btn-lecture fail" disabled>불합격</button></template>
                                    <template v-if="lecture.qualification_status == 4"><a :href="`/certificate/pdf/program/${lecture.program_id}/user/${lecture.user_id}/completion`" class="btn-lecture" target="_blank"><em>자격증 보기</em></a></template>
                                </template>
                                <template v-if="lecture.programs_completion_id  != null">
                                    <template v-if="lecture.completion_status == 2"><button class="btn-lecture fail" disabled>수료증 대기중</button></template>
                                    <template v-if="lecture.completion_status == 3"><button class="btn-lecture fail" disabled>불합격</button></template>
                                    <template v-if="lecture.completion_status == 4"><a :href="`/certificate/pdf/program/${lecture.program_id}/user/${lecture.user_id}/qualification`" class="btn-lecture" target="_blank">수료증 보기</a></template>
                                </template>
                            </template>
                            <!-- <a class="btn-lecture fail">불합격</a> -->
                            <!-- 대기중 -->
                        </div>
                    </div>
                </li>
                <li class="none" v-if="lectures.length <= 0">
                    <p>발급 된 증명서가 없습니다.</p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

export default {
    name: 'MypageLectureCertificateList',
    props: {
        'listData': Array,
        'mobile': Boolean,
    },
    computed: {},
    data() {
        return {
            lectures: []
        }
    },
    watch: {
        listData() {
            this.lectures = this.listData;
        }
    },
}
</script>

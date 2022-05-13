<template>
    <div class="mypage-certificateList">
        <div class="mypage-content">
            <ul>
                <li v-for="lecture in lectures" :key="lecture.program.id">
                    <div class="content-information-wrap">
                        <figure class="content-image">
                            <a :href="'/lectures/' + lecture.program.id">
                                <img :src="lecture.program.thumbnail.url" alt="강의사진">
                                <template v-if="lecture.program.completion_id && lecture.program.qualification_id">
                                    <div class="certificate-mark">수료/자격증</div>
                                </template>
                                <template v-else-if="lecture.program.completion_id">
                                    <div class="certificate-mark">수료증</div>
                                </template>
                                <template v-else-if="lecture.program.qualification_id">
                                    <div class="certificate-mark">자격증</div>
                                </template>
                            </a>
                        </figure>
                        <div class="content-information">
                            <div class="lecture-sort">
                                <span class="lecture-type">{{ lecture.program.minor_category_name }}</span>

                                <p class="lecture-date" v-if="lecture.program.minor_category_name!='스토어'">
                                    <template v-if="lecture.program.is_online==true">수강기간 {{ lecture.program.term }}일</template>
                                </p>
                            </div>
                            <h3 class="lecture-title">
                                <a :href="'/lectures/' + lecture.program.id">{{ lecture.program.title }}</a>
                            </h3>
                            <table v-if="lecture.program.is_online">
                                <tr>
                                    <th>강의시간</th>
                                    <td><p class="lecture-length">{{ lecture.program.running_time }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제금액</th>
                                    <td>
                                        <p class="lecture-pay">
                                            {{
                                                lecture.program.is_free == 1 ? '무료' :
                                                    Helper.numberWithCommas(lecture.program.price) + '원'
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
                                            {{ lecture.program.place.korean_time }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <th>강의장소</th>
                                    <td><p class="lecture-length lecture-place">{{
                                            lecture.program.place.full_address
                                        }}</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="lecture-under">
                        <div class="btn-zone">
                            <template v-if="lecture.program.qualification_profiles[0] != null">
                                <template v-if="lecture.program.qualification_profiles[0].status == 2"><p>자격증 대기중</p></template>
                                <template v-if="lecture.program.qualification_profiles[0].status == 3"><button class="btn-lecture fail" disabled>불합격</button></template>
                                <template v-if="lecture.program.qualification_profiles[0].status == 4"><a class="btn-lecture"><em>자격증 보기</em></a></template>
                            </template>
                            <template v-if="lecture.program.completion_profiles[0]  != null">
                                <template v-if="lecture.program.completion_profiles[0].status == 2"><p>수료증 대기중</p></template>
                                <template v-if="lecture.program.completion_profiles[0].status == 3"><button class="btn-lecture fail" disabled>불합격</button></template>
                                <template v-if="lecture.program.completion_profiles[0].status == 4"><a class="btn-lecture">수료증 보기</a></template>
                            </template>
                            <!-- <a class="btn-lecture fail">불합격</a> -->
                            <!-- 대기중 -->
                        </div>
                    </div>
                </li>
                <div class="content-none" v-if="lectures.length == 0">발급 된 증명서가 없습니다.</div>
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

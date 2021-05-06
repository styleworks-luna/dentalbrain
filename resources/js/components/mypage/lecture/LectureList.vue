<template>
    <div class="mypage-content">
        <ul>
            <li v-for="lecture in lectures" :key="lecture.id">
                <div class="content-information-wrap">
                    <figure class="content-image">
                        <a :href="'/lectures/' + lecture.ticket.program.id">
                            <img :src="lecture.ticket.program.thumbnail.url" alt="강의사진">
                        </a>
                    </figure>
                    <div class="content-information">
                        <div class="lecture-sort">
                            <span class="online" v-if="lecture.ticket.program.is_online">온라인</span>
                            <span class="offline" v-else>오프라인</span>
                            <p class="lecture-subject">
                                <template v-if="lecture.ticket.program.minor_category_name">
                                    {{ lecture.ticket.program.major_category_name }} &middot;
                                    {{ lecture.ticket.program.minor_category_name }}
                                </template>
                                <template v-else>
                                    {{ lecture.ticket.program.major_category_name }}
                                </template>
                            </p>
                        </div>
                        <h3 class="lecture-title">
                            <a :href="'/lectures/' + lecture.ticket.program.id">{{ lecture.ticket.program.title }}</a>
                        </h3>
                        <table v-if="lecture.ticket.program.is_online">
                            <tr>
                                <th>강의시간</th>
                                <td><p class="lecture-length">{{ lecture.ticket.program.running_time }}</p>
                                </td>
                            </tr>
                            <tr>
                                <th>결제금액</th>
                                <td>
                                    <p class="lecture-pay">
                                        <template v-if="!lecture.is_repeated">
                                            {{
                                                lecture.ticket.price == 0 ? '무료' :
                                                    Helper.numberWithCommas(lecture.ticket.price) + '원'
                                            }}
                                        </template>
                                        <template v-else>
                                            {{
                                                '재수강 할인가: ' + Helper.numberWithCommas(lecture.ticket.repeat_price) + '원'
                                            }}
                                        </template>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table v-else>
                            <tr>
                                <th>강의일시</th>
                                <td>
                                    <p class="lecture-length">
                                        {{ lecture.ticket.program.place.korean_time }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <th>강의장소</th>
                                <td><p class="lecture-length lecture-place">{{
                                        lecture.ticket.program.place.full_address
                                    }}</p></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="lecture-under">
                    <div class="lecture-sub-information">
                        <!-- 입금 대기 상태 -->
                        <template v-if="lecture.pay_status == 1 || lecture.pay_status == 5">
                            <div class="offline-lecture-pay">
                                <p>결제금액</p>
                                <div class="d-day"><em>
                                    <!-- 재결제 금액 -->
                                    <template v-if="lecture.is_repeated">
                                        {{ Helper.numberWithCommas(lecture.ticket.repeat_price) + '원' }}
                                    </template>
                                    <!-- 결제 금액 -->
                                    <template v-else>
                                        {{ Helper.numberWithCommas(lecture.ticket.price) + '원' }}
                                    </template>
                                </em></div>
                            </div>
                        </template>

                        <!-- 입금완료 -->
                        <template v-else>
                            <!-- 온라인 -->
                            <div class="content-time" v-if="lecture.ticket.program.is_online">
                                <p>시청 가능 기간</p>
                                <!-- 남은 기간 많을 때 -->
                                <div class="d-day" v-if="lecture.left_days > 0">
                                    <em>{{ lecture.left_days }}일</em> 남음
                                </div>

                                <!-- 남은 기간 0일 이하이지만 기간 종료 전 -->
                                <div class="d-day" v-else-if="lecture.left_days === '0'">
                                    <em>{{ Helper.getTimeFormat(lecture.expired_at) }}</em> 종료
                                </div>

                                <!-- 기간 종료 -->
                                <div class="d-day" v-else><em>만료</em></div>
                                <div class="dedicate" v-if="lecture.left_days < 0 && mobile"><p>재수강시 30% 할인 적용됩니다.</p></div>
                                <div class="dedicate" v-else>{{ Helper.dateFormatYDMByComma(lecture.expired_at) }} 까지</div>
                            </div>

                            <!-- 오프라인 -->
                            <div class="offline-lecture-pay" v-else>
                                <p>결제금액</p>
                                <div class="d-day"><em>
                                    {{
                                        lecture.ticket.price == 0 ? '무료' : Helper.numberWithCommas(lecture.ticket.price) + '원'
                                    }}
                                </em></div>
                            </div>
                        </template>

                    </div>

                    <div class="btn-zone">
                        <!-- 무통장입금 대기 -->
                        <template v-if="lecture.pay_status == 1">
                            <div class="content-button">
                                <div class="btn-wrap">
                                    <a href="" class="btn-none-active" @click.prevent>입금대기중</a>
                                </div>
                            </div>
                        </template>

                        <!-- 별도 결제 대기 -->
                        <template v-else-if="lecture.pay_status == 5">
                            <div class="content-button-full">
                                <div class="btn-wrap">
                                    <a href="" class="btn-none-active" @click.prevent>입금대기중</a>
                                    <a href="" @click.prevent="destroy(lecture.ticket.program_id)">신청취소</a>
                                </div>
                            </div>
                        </template>

                        <!-- 카드 결제, 결제 완료 시 -->
                        <template v-else>
                            <!-- 온라인 -->
                            <template v-if="lecture.ticket.program.is_online">
                                <!-- 기간 종료 전 -->
                                <div
                                    :class="lecture.is_watched == 0 && lecture.left_days > lecture.ticket.term - 8 ? 'content-button-full' : 'content-button'"
                                    v-if="lecture.left_days > 0 || lecture.left_days === '0'">
                                    <a :href="`/lectures/${lecture.ticket.program.id}/watch/${lecture.ticket.program.lectures[0].id}`">
                                        강의 시청하기
                                    </a>
                                    <a href=""
                                       v-if="lecture.left_days > lecture.ticket.term - 8 && lecture.is_watched == 0"
                                       @click.prevent="popUpStatus(lecture.id)">
                                        환불요청
                                    </a>
                                </div>
                                <!-- 기간 종료 -->
                                <div class="content-button-full"
                                     v-else-if="Helper.dateCompareWithNow(lecture.expired_at) < 0">
                                    <a :href="'/lectures/' + lecture.ticket.program.id" class="apply-btn">강의신청</a>
                                    <p v-if="!mobile">재수강시<br>30% 할인 적용됩니다.</p>
                                </div>
                            </template>

                            <!-- 오프라인 -->
                            <template v-else>
                                <div class="content-button-full"
                                     v-if="Helper.dateCompareWithNow(lecture.ticket.program.place.ended_at) > 0">
                                    <div class="btn-wrap">
                                        <a :href="`/account/lectures/${lecture.ticket.program.id}`"
                                           :class="Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) > milliSecondsDay ? '' : 'for-margin'">수정하기</a>

                                        <!-- 오프라인 유료 -->
                                        <template v-if="lecture.ticket.is_free == 0">
                                            <!-- 2일 이상일 때 취소(자동) -->
                                            <template
                                                v-if="Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) > milliSecondsDay * 2">
                                                <a href="" @click.prevent="popUpStatus(lecture.id)">취소하기</a>
                                            </template>
                                            <!-- 2일 이하 1일 전 일때 취소(수동, 관리자) -->
                                            <template v-else-if=" Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) < milliSecondsDay * 2
                                               && Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) > milliSecondsDay">
                                                <!-- 환불신청 전 -->
                                                <a href="" v-if="lecture.pay_status === 2"
                                                   @click.prevent="popUpManualStatus(lecture.id)">
                                                    취소하기
                                                </a>
                                                <!-- 환불 신청 후 -->
                                                <a href="" v-else-if="lecture.pay_status === 4" @click.prevent>환불요청 중</a>
                                            </template>
                                        </template>

                                        <!-- 오프라인 무료 -->
                                        <template v-else-if="lecture.ticket.is_free != 0">
                                            <!-- 하루 이상 일때 취소 -->
                                            <a href=""
                                               v-if="Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) > milliSecondsDay"
                                               @click.prevent="popUpStatus(lecture.id)">취소하기</a>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </template>

                    </div>
                </div>
            </li>
            <li class="content-none" v-if="lectures.length == 0">신청한 강의가 없습니다.</li>
        </ul>

        <refund-pop v-if="modalData.ticket.is_free == 0 && showModal"
                    :methodTo="modalData.payment.method"
                    :programIdTo="modalData.ticket.program.id"
                    @close="toggleModal"></refund-pop>

        <refund-free-pop v-if="modalData.ticket.is_free != 0 && showModal"
                         :programIdTo="modalData.ticket.program.id"
                         @close="toggleModal">
        </refund-free-pop>

        <refund-manual-pop v-if="modalData.ticket.is_free == 0 && showManualModal"
                           :methodTo="modalData.payment.method"
                           :programIdTo="modalData.ticket.program.id"
                           @close="toggleManualModal">
        </refund-manual-pop>

        <div class="dim" v-if="showModal || showManualModal"></div>
    </div>
</template>

<script>
import RefundPop from '@/components/mypage/lecture/RefundPop.vue'
import RefundFreePop from '@/components/mypage/lecture/RefundFreePop.vue'
import RefundManualPop from '@/components/mypage/lecture/RefundManualPop.vue'

import Mypage from "@/api/mypage/Mypage.js"

export default {
    name: 'MypageLectureList',
    components: {
        RefundPop,
        RefundFreePop,
        RefundManualPop,
    },
    props: {
        'list': Array,
        'mobile': Boolean,
    },
    computed: {},
    data() {
        return {
            lectures: [],
            milliSecondsDay: 86400000,
            showModal: false,
            showManualModal: false,
            modalData: {
                ticket: {},
                payment: {}
            }
        }
    },
    watch: {
        list() {
            this.lectures = this.list;
        }
    },
    methods: {
        popUpStatus(id) {
            if (id) {
                this.modalData = this.list.find(data => data.id === id);
            }
            this.showModal = true;
        },
        popUpManualStatus(id) {
            if (id) {
                this.modalData = this.list.find(data => data.id === id);
            }
            this.showManualModal = true;
        },
        toggleModal() {
            this.showModal = !this.showModal;
        },
        toggleManualModal() {
            this.showManualModal = !this.showManualModal;
        },
        destroy(programId) {
            Mypage.destroy(programId).then(res => {
                alert(res.data.msg);
                window.location.reload()
            });
        }
    }
}
</script>

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
                                {{ lecture.ticket.program.major_category_name }} &middot;
                                {{ lecture.ticket.program.minor_category_name }}
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
                                <td><p class="lecture-pay">
                                    {{
                                        lecture.ticket.price == 0 ? '무료' : Helper.numberWithCommas(lecture.ticket.price) + '원'
                                    }}
                                </p></td>
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
                                <td><p class="lecture-length">{{ lecture.ticket.program.place.full_address }}</p></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="lecture-sub-information">
                    <div class="content-time" v-if="lecture.ticket.program.is_online">
                        <p>시청 가능 기간</p>
                        <div class="d-day" v-if="lecture.left_days > 0">
                            <em>{{ lecture.left_days }}일</em> 남음
                        </div>
                        <div class="d-day" v-else-if="lecture.left_days == 0">
                            <em>{{ Helper.getTimeFormat(lecture.expired_at) }}</em> 종료
                        </div>
                        <div class="d-day" v-else><em>만료</em></div>
                        <div class="dedicate">{{ Helper.dateFormatYDM(lecture.expired_at) }} 까지</div>
                    </div>
                    <div class="offline-lecture-pay" v-else>
                        <p>결제금액</p>
                        <div class="d-day"><em>
                            {{ lecture.ticket.price == 0 ? '무료' : Helper.numberWithCommas(lecture.ticket.price) + '원' }}
                        </em></div>
                    </div>
                </div>
                <div class="btn-zone">
                    <div
                        :class="lecture.is_watched == 0 && lecture.left_days > lecture.ticket.term - 8 ? 'content-button-offline' : 'content-button'"
                        v-if="lecture.ticket.program.is_online && lecture.left_days >= 0">
                        <a :href="`/lectures/${lecture.ticket.program.id}/watch/${lecture.ticket.program.lectures[0].id}`">강의
                            시청하기</a>
                        <a href="" v-if="lecture.left_days > lecture.ticket.term - 8 && lecture.is_watched == 0"
                           @click.prevent="popUpStatus(lecture.id)">환불요청</a>
                    </div>
                    <div class="content-button" v-else-if="lecture.ticket.program.is_online && lecture.left_days <= 0">
                        <a :href="'/lectures/' + lecture.ticket.program.id" class="apply-btn">강의신청</a>
                        <p>재수강시<br>30% 할인 적용됩니다.</p>
                    </div>
                    <div class="content-button-offline"
                         v-else-if="!lecture.ticket.program.is_online && Helper.dateCompareWithNow(lecture.ticket.program.place.ended_at) > 0">
                        <div class="btn-wrap">
                            <a href=""
                               :class="Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) > milliSecondsDay ? '' : 'for-margin'">수정하기</a>
                            <template v-if="lecture.ticket.is_free == 0">
                                <template v-if="Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) > milliSecondsDay * 2">
                                    <a href="" @click.prevent="popUpStatus(lecture.id)">취소하기</a>
                                </template>
                                <template v-else-if=" Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) < milliSecondsDay * 2
                                               && Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) > milliSecondsDay">
                                    <a href="" v-if="lecture.pay_status === 2" @click.prevent="popUpManualStatus(lecture.id)">
                                        취소하기
                                    </a>
                                    <a href="" v-else-if="lecture.pay_status ===4" @click.prevent>환불요청 중</a>
                                </template>
                            </template>
                            <template v-else-if="lecture.ticket.is_free != 0">
                                <a href="" v-if="Helper.dateCompareWithNow(lecture.ticket.program.place.started_at) > milliSecondsDay"
                                   @click.prevent="popUpStatus(lecture.id)">취소하기</a>
                            </template>
                        </div>
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

export default {
    name: 'MypageLectureList',
    components: {
        RefundPop,
        RefundFreePop,
        RefundManualPop,
    },
    props: {
        'list': Array
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
        }
    }
}
</script>

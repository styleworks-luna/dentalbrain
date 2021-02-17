<template>
    <div class="mypage-content">
        <ul>
            <li v-for="lecture in lectures" :key="lecture.id">
                <div class="content-information-wrap">
                    <figure class="content-image">
                        <img :src="lecture.ticket.program.thumbnail.url" alt="강의사진">
                    </figure>
                    <div class="content-information">
                        <div class="lecture-sort">
                            <span class="online" v-if="lecture.ticket.program.is_online">온라인</span>
                            <span class="offline" v-else>오프라인</span>
                            <p class="lecture-subject">{{ lecture.ticket.program.major_category_name }} &middot
                                {{ lecture.ticket.program.minor_category_name }}</p>
                        </div>
                        <h3 class="lecture-title">{{ lecture.ticket.program.title }}</h3>
                        <table v-if="lecture.ticket.program.is_online">
                            <tr>
                                <th>강의시간</th>
                                <td><p class="lecture-length">{{ lecture.ticket.program.running_time }}</p>
                                </td>
                            </tr>
                            <tr>
                                <th>결제금액</th>
                                <td><p class="lecture-pay">
                                    {{ lecture.ticket.price == 0 ? '무료' : Helper.numberWithCommas(lecture.ticket.price) + '원' }}</p></td>
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
                        <div class="d-day" v-if="lecture.left_days != 0">
                            <em>{{ lecture.left_days }}</em> 남음
                        </div>
                        <div class="d-day" v-else><em>만료</em></div>
                        <div class="dedicate">{{ Helper.dateFormatYDM(lecture.expired_at) }} 까지</div>
                    </div>
                    <div class="offline-lecture-pay" v-else>
                        <p>결제금액</p>
                        <div class="d-day"><em>{{ lecture.ticket.price == 0 ? '무료' : Helper.numberWithCommas(lecture.ticket.price) + '원' }}</em></div>
                    </div>
                </div>
                <div class="btn-zone">
                    <div class="content-button" v-if="lecture.ticket.program.is_online && lecture.left_days != 0">
                        <a href="">강의 시청하기</a>
                    </div>
                    <div class="content-button" v-else-if="lecture.ticket.program.is_online && lecture.left_days <= 0">
                        <a href="" class="apply-btn">강의신청</a>
                        <p>재수강시<br>30% 할인 적용됩니다.</p>
                    </div>
                    <div class="content-button-offline" v-else-if="!lecture.ticket.program.is_online && Helper.dateCompare(lecture.ticket.program.place.ended_at) < 0">
                        <div class="btn-wrap">
                            <a href="">수정하기</a>
                            <a href="" class="cancel">취소하기</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: 'MypageLectureList',
    props: {
        'list': Array
    },
    data() {
        return {
            lectures: []
        }
    },
    watch: {
        list() {
            this.lectures = this.list;
        }
    }
}
</script>

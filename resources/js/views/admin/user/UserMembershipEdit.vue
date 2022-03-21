<template>
    <layout title="유료회원정보 상세" class="user-membership">
        <template v-slot:body>
            <single-group name="아이디"
                          :isRow="true"
                          :size="3">
                <template v-slot:content>
                    {{ login_id }}
                </template>
            </single-group>

            <single-group name="이름"
                          :isRow="true"
                          :size="3">
                <template v-slot:content>
                    {{ name }}
                </template>
            </single-group>

            <single-group name="이메일"
                          :isRow="true"
                          :size="3">
                <template v-slot:content>
                    {{ email }}
                </template>
            </single-group>

            <single-group name="전화번호"
                          :isRow="true"
                          :size="3">
                <template v-slot:content>
                    {{ phone }}
                </template>
            </single-group>

            <single-group name="직업군"
                          :isRow="true"
                          :size="4">
                <template v-slot:content>
                    <div class="select-box-wrap float-left mr-3">
                        {{ jobName }}
                    </div>

                    <div class="input-wrap float-left" v-if="license_num">
                        면허번호 : {{ license_num }}
                    </div>

                </template>
            </single-group>

            <single-group name="근무처"
                          :isRow="true"
                          :size="4">
                <template v-slot:content>
                    <div class="select-box-wrap float-left mr-3">
                        {{ work_company }}
                    </div>
                </template>
            </single-group>

            <single-group name="가입일자"
                          :isRow="true"
                          :size="4">
                <template v-slot:content>
                    <div class="select-box-wrap float-left mr-3">
                        {{ created_at }}
                    </div>
                </template>
            </single-group>

            <div class="membership-content mt-5">
                <h2>강의 신청 정보</h2>
                <table class="w-100">
                    <colgroup>
                        <col style="width: 5%">
                        <col style="width: 7%">
                        <col style="width: 20%">
                        <col style="width: 10%">
                        <col style="width: 15%">
                        <col style="width: 15%">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>번호</th>
                        <th>소분류</th>
                        <th>강의제목</th>
                        <th>결제금액</th>
                        <th>시청기간</th>
                        <th>신청일시</th>
                    </tr>
                    </thead>
                </table>
            </div>

            <div class="membership-content mt-5">
                <h2>유료회원 결제 내역</h2>
                <table class="w-100">
                    <colgroup>
                        <col style="width: 55%">
                        <col style="width: 10%">
                        <col style="width: 10%">
                        <col style="width: 10%">
                        <col style="width: 15%">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>날짜</th>
                        <th>결제일수</th>
                        <th>결제상태</th>
                        <th>결제방식</th>
                        <th>상태</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="(membership, idx) in memberships">
                        <tr>
                            <td :style="membership.pay_status == 3 || membership.pay_status == 5 ? 'background-color: #9999': ''">
                                <div class="date-wrap overflow:hidden">
                                    <date-picker class=" float-left mr-3"
                                                 :time="memberships_dates[idx].start_date"
                                                 :index="idx"
                                                 @setTime="handleSetStartDate"></date-picker>
                                    <time-picker class=" float-left mr-3"
                                                 :index="idx"
                                                 :time="memberships_dates[idx].start_time"
                                                 @setTime="handleSetStartTime"></time-picker>

                                    <p class="float-left mr-3 mt-2">부터</p>

                                    <date-picker class=" float-left mr-3"
                                                 :time="memberships_dates[idx].end_date"
                                                 :index="idx"
                                                 @setTime="handleSetEndDate"></date-picker>
                                    <time-picker class="float-left"
                                                 :time="memberships_dates[idx].end_time"
                                                 :index="idx"
                                                 @setTime="handleSetEndTime"></time-picker>
                                </div>
                            </td>
                            <td>{{ membership.applied_days ? membership.applied_days + '일' : '' }}</td>
                            <td>{{ membership.payment ? paymentStatus(membership.payment.status) : '' }}</td>
                            <td>{{ membership.payment ? membership.payment.method : '관리자 등록' }}</td>
                            <td>
                                <template v-if="membership.pay_status == 0">
                                    결제 전
                                </template>
                                <template v-else-if="membership.pay_status === 1">
                                    입금 대기
                                </template>
                                <template v-else-if="membership.pay_status === 2">
                                    <a href="#" class="btn btn-danger text-white"
                                       @click.prevent="membership.payment ? [handleSetCancelLayer(membership.id, membership.payment.method), getCancelId(membership.id,true)] :
                                   [getCancelId(membership.id,true),cancelMembershipAnotherPayment()]">
                                        결제 취소
                                    </a>
                                </template>
                                <template v-else-if="membership.pay_status === 3">
                                    취소 완료
                                </template>
                                <template v-else-if="membership.pay_status === 4">
                                    <a href="#" class="btn btn-danger text-white"
                                       @click.prevent="[handleSetCancelLayer(membership.id, membership.payment.method), getCancelId(membership.id,true)]">
                                        결제 취소
                                    </a>
                                </template>
                                <!-- 별도결제 확인 -->
                                <template v-else-if="membership.pay_status === 5">
                                    <a href="#" class="btn btn-success"
                                       @click.prevent="confirmMembershipPayment(membership.id)">
                                        결제 확인</a>
                                    <a href="#" class="btn btn-danger text-white"
                                       @click.prevent="[getCancelId(membership.id,true),cancelMembershipAnotherPayment()]">
                                        결제 취소
                                    </a>
                                </template>
                                <template v-else-if="membership.pay_status === 6">
                                    <a href="#" class="btn btn-danger text-white"
                                       @click.prevent="[getCancelId(membership.id,true),cancelMembershipAnotherPayment()]">
                                        결제 취소
                                    </a>
                                </template>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
                <div class="btn-zone mt-5">
                    <button class="btn btn-outline-dark d-block w-100" @click="addMembership">추가</button>
                </div>
            </div>
            <payment-cancel-layer v-if="cancelLayer"
                                  :paymentMethod="paymentMethod"
                                  @setCancelLayer="handleSetCancelLayer"
                                  @cancelPayment="cancelMembershipPayment"></payment-cancel-layer>
        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="button" class="btn btn-info" @click="update">수정</button>
                <a @click="$router.go(-1)"
                   class="btn btn-dark text-white">취소
                </a>
            </div>
        </template>
    </layout>
</template>

<script>
//api
import User from '@/api/admin/user/User.js';

//Mixin
import {UserMixin} from '@/mixins/admin/user/User.js'

// mixins
import {PaymentCancelMixin} from '@/mixins/admin/payment/Cancel.js';
import {PaymentConfirmMixin} from '@/mixins/admin/payment/Confirm.js';

export default {
    name: "UserMembershipEdit",
    mixins: [
        UserMixin,
        PaymentCancelMixin,
        PaymentConfirmMixin
    ],
    data() {
        return {
            id: '',
            user_id: '',
            membership_id: '',
            data: {},
            page: this.$route.params.page,
            // disabled: true,
        }
    },
    created() {
        this.user_id = this.$route.params.id;
    },
    mounted() {
        this.getData();
    },
    computed: {
        jobName() {
            switch (this.job_name_id) {
                case 1:
                    return '치과의사';
                case 2:
                    return '치과위생사';
                case 3:
                    return '치과조무사';
                case 4:
                    return '코디네이터';
                case 5:
                    return '학생';
                case 6:
                    return '기타';
            }
        },
    },
    methods: {
        getData() {
            User.getEditMembershipData(this.user_id).then(res => {

                this.memberships_dates = [];
                const userResult = res.data.user;
                const membershipResult = res.data.memberships;

                this.login_id = userResult.login_id;
                this.name = userResult.name;
                this.email = userResult.email;
                this.phone = userResult.phone;
                this.job_name_id = userResult.job_name_id;
                this.license_num = userResult.license_num;
                this.work_company = userResult.work_company;
                this.created_at = userResult.created_at;
                this.is_paid = userResult.is_paid;

                this.has_membership = userResult.has_membership;

                this.memberships = membershipResult;

                membershipResult.forEach((x, idx) => {
                    if (x.started_at && x.expired_at) {
                        this.memberships_dates.push({
                            start_date: this.Helper.dateFullFormat(x.started_at),
                            start_time: this.Helper.getTimeFormat(x.started_at),
                            end_date: this.Helper.dateFullFormat(x.expired_at),
                            end_time: this.Helper.getTimeFormat(x.started_at)
                        });
                    } else {
                        this.memberships_dates.push({
                            start_date: null,
                            start_time: null,
                            end_date: null,
                            end_time: null
                        });
                    }
                });
            });
        },
        paymentStatus(status) {
            switch (status) {
                case 'READY':
                    return '결제 준비됨';

                case 'IN_PROGRESS':
                    return '결제 진행중';

                case 'WAITING_FOR_DEPOSIT':
                    return '입금 대기 중';

                case 'DONE':
                    return '결제 완료';

                case 'CANCELED':
                    return '결제 취소';

                case 'ABORTED':
                    return '결제 중단';

                case 'PARTIAL_CANCELED':
                    return '부분 취소';

                case 'ANOTHER_PROGRESS' :
                    return '별도 결제 대기 중';

                case 'ANOTHER_REJECTED' :
                    return '별도 결제 취소';

                case 'ANOTHER_DONE' :
                    return '결제 완료';
            }
        },
        addMembership() {
            this.memberships.push({
                started_at: "",
                expired_at: "",
                payment: {
                    status: "",
                    method: "",
                }
            });
            this.memberships_dates.push({
                start_date: "",
                start_time: "",
                end_date: "",
                end_time: "",
            });
        },
        update() {
            this.memberships.forEach((x, index) => {
                x.started_at = this.memberships_dates[index].start_date ? `${this.Helper.dateFormatYDM(this.memberships_dates[index].start_date)} ${this.memberships_dates[index].start_time}` : null;
                x.expired_at = this.memberships_dates[index].end_date ? `${this.Helper.dateFormatYDM(this.memberships_dates[index].end_date)} ${this.memberships_dates[index].end_time}` : null;
            });

            let data = {
                memberships: this.memberships,
            };

            User.updateMembership(this.user_id, data).then(res => {
                alert(res.data.msg);
                this.$router.go(-1);
            })
        },
        getCancelId(data, boolean) {
            this.is_membership = boolean
            this.id = data;
        },
    }
}
;
</script>

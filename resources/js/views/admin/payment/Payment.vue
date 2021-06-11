<template>
    <layout title="결제정보">
        <template v-slot:button>
            <a :href="`/api/admin/payment/export?keyword=${keyword}&start_date=${startDateForm}&end_date=${endDateForm}&status=${orderStatus}&category=${order}`"
               class="btn btn-info" download>엑셀 다운로드</a>
        </template>
        <template v-slot:search>
            <div class="float-left">
                <p style="font-size: 18px;">총 결제건수: {{ count }}건, 총 결제금액: {{ sum }}원 </p>
            </div>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <label class="col-form-label d-block float-left mr-1">시작일</label>
                    <date-picker class="mr-3" @setTime="handleSetStartDate"></date-picker>
                    <p class="float-left mr-2 mt-2">~</p>
                    <label class="col-form-label d-block float-left mr-1">종료일</label>
                    <date-picker class="mr-3" @setTime="handleSetEndDate"></date-picker>
                    <select-box class="form-control"
                                text="구분 선택"
                                :value="order"
                                :options="orderOptions"
                                @setValue="handleSetOrder"></select-box>
                    <select-box class="form-control"
                                text="상태 선택"
                                :value="orderStatus"
                                :options="orderStatusOptions"
                                @setValue="handleSetStatusOrder"></select-box>
                    <div class="input-group">
                        <input class="form-control"
                               type="text"
                               placeholder="제목, 이름, 이메일주소, 결제금액"
                               v-model="keyword">
                        <span class="input-group-append">
                            <button class="btn btn-primary" type="submit">검색</button>
                        </span>
                    </div>
                </form>
            </div>
        </template>
        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="payments.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <template v-if="slotProps.row.membership_id">
                        <td>
                            유료회원
                        </td>
                    </template>
                    <template v-else>
                        <td>
                            {{ slotProps.row.is_online ? '온라인' : '오프라인' }}
                        </td>
                    </template>
                    <template v-if="slotProps.row.membership_id">
                        <td>
                            유료회원 결제
                        </td>
                    </template>
                    <template v-else>
                        <td>
                            <a :href="Helper.urlFormat(`/lectures/${slotProps.row.program_id}`)" target="_blank">
                                {{ slotProps.row.title }}
                            </a>
                        </td>
                    </template>
                    <td>
                        <router-link :to="`/admin/user/user/${slotProps.row.user_id}/1`">
                            {{ slotProps.row.name }}
                        </router-link>
                        <br>
                        {{ slotProps.row.email }}
                    </td>
                    <td>{{ Helper.numberWithCommas(slotProps.row.totalAmount) }}</td>
                    <td>{{ slotProps.row.method }}</td>
                    <td>
                        {{ paymentStatus(slotProps.row.status) }}<br>

                        <a :href="slotProps.row.receiptUrl"
                           target="_blank"
                           v-if="slotProps.row.receiptUrl">(영수증)</a>
                    </td>
                    <td>{{ slotProps.row.approvedAt || '결제 대기중' }}</td>
                    <template v-if="slotProps.row.membership_pay_status">
                        <td>
                            <template v-if="slotProps.row.membership_pay_status == 0">
                                결제 전
                            </template>
                            <template v-else-if="slotProps.row.membership_pay_status === 1">
                                입금 대기
                            </template>
                            <template v-else-if="slotProps.row.membership_pay_status === 2">
                                결제 완료
                            </template>
                            <template v-else-if="slotProps.row.membership_pay_status === 3">
                                취소 완료
                            </template>
                            <template v-else-if="slotProps.row.membership_pay_status === 4">
                                결제 완료_2
                            </template>
                            <template v-else-if="slotProps.row.membership_pay_status === 5">
                                <a href="#" class="btn btn-success"
                                   @click.prevent="confirmMembershipPayment(slotProps.row.membership_id)">
                                    결제 확인</a>
                            </template>
                            <template v-else-if="slotProps.row.membership_pay_status === 6">
                                별도 결제 결제 완료
                            </template>
                        </td>
                    </template>
                    <template v-else>
                        <td>
                            <template v-if="slotProps.row.program_pay_status === 0">
                                결제 전
                            </template>
                            <template v-else-if="slotProps.row.program_pay_status === 1">
                                입금 대기
                            </template>
                            <template v-else-if="slotProps.row.program_pay_status === 3">
                                취소 완료
                            </template>
                            <template v-else-if="slotProps.row.program_pay_status === 4">
                                <a href="#" class="btn btn-danger text-white"
                                   @click.prevent="[handleSetCancelLayer(slotProps.row.student_id, slotProps.row.method), getProgramId(slotProps.row.program_id)]">
                                    결제 취소
                                </a>
                            </template>
                            <template v-else-if="slotProps.row.program_pay_status === 2">
                                <a href="#" class="btn btn-danger text-white"
                                   @click.prevent="[handleSetCancelLayer(slotProps.row.student_id, slotProps.row.method), getProgramId(slotProps.row.program_id)]">
                                    결제 취소
                                </a>
                            </template>
                            <!-- 별도 결제 입금 전 -->
                            <template v-else-if="slotProps.row.program_pay_status === 5">
                                <a href="#" class="btn btn-success"
                                   @click.prevent="[handleSetIsOnline(slotProps.row.is_online),handleSetConfirmLayer( slotProps.row.student_id,slotProps.row.program_id)]">결제
                                    확인</a>
                                <template v-if="slotProps.row.is_online == true">
                                    <a href="#" class="btn btn-danger text-white"
                                       @click.prevent="cancelLecture(slotProps.row.student_id, slotProps.row.program_id)">
                                        신청 취소
                                    </a>
                                </template>
                                <template v-else>
                                    <a href="#" class="btn btn-danger text-white"
                                       @click.prevent="cancelOfflinePayment(slotProps.row.student_id, slotProps.row.program_id)">
                                        신청 취소
                                    </a>
                                </template>
                            </template>
                            <!-- 별도 결제 입금 후 -->
                            <template v-else-if="slotProps.row.program_pay_status === 6">
                                <a href="#" class="btn btn-secondary"
                                   @click.prevent="revertConfirm( slotProps.row.student_id, slotProps.row.program_id)">결제
                                    완료</a>
                                <template v-if="slotProps.row.is_online == true">
                                    <a href="#" class="btn btn-danger text-white"
                                       @click.prevent="cancelLecture(slotProps.row.student_id, slotProps.row.program_id)">
                                        신청 취소
                                    </a>
                                </template>
                                <template v-else>
                                    <a href="#" class="btn btn-danger text-white"
                                       @click.prevent="cancelOfflinePayment(slotProps.row.student_id, slotProps.row.program_id)">
                                        신청 취소
                                    </a>
                                </template>
                            </template>
                        </td>
                    </template>

                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="payments" @pagination-change-page="getData" class="mb-0">
                        <span slot="prev-nav">‹</span>
                        <span slot="next-nav">›</span>
                    </pagination>
                </nav>
            </div>

            <payment-cancel-layer v-if="cancelLayer"
                                  :paymentMethod="paymentMethod"
                                  @setCancelLayer="handleSetCancelLayer"
                                  @cancelPayment="cancelPayment"></payment-cancel-layer>

            <payment-confirm-layer v-if="confirmLayer"
                                   :is_online="is_onlineTo"
                                   @setConfirmLayer="handleSetConfirmLayer"
                                   @confirmPayment="confirmPayment"></payment-confirm-layer>
        </template>
    </layout>
</template>

<script>
// component
import Table from '@/components/admin/grid/Table.vue';
import SelectBox from '@/components/common/SelectBox.vue';
import DatePicker from '@/components/common/DatePicker.vue'

//api
import {getData} from '@/api/admin/payment/Payment.js'

// mixins
import {PaymentCancelMixin} from '@/mixins/admin/payment/Cancel.js';
import {PaymentConfirmMixin} from '@/mixins/admin/payment/Confirm.js';

export default {
    name: 'AdminPayment',
    mixins: [
        PaymentCancelMixin,
        PaymentConfirmMixin
    ],
    components: {
        'table-grid': Table,
        SelectBox,
        DatePicker,
    },
    data() {
        return {
            id: '',
            payments: {
                data: []
            },
            page: this.$route.params.page || 1,
            order: '',
            keyword: '',
            orderStatus: '',
            startDate: '',
            endDate: '',
            count: 0,
            sum: '',
        }
    },
    mounted() {
        this.getData();
    },
    computed: {
        tableCol() {
            return [
                {
                    name: 'id',
                    text: '번호',
                    width: '5%'
                },
                {
                    name: 'category',
                    text: '구분',
                    width: '8%'
                },
                {
                    name: 'title',
                    text: '제목',
                    width: '24%'
                },
                {
                    name: 'user',
                    text: '결제자',
                    width: '10%'
                },
                {
                    name: 'price',
                    text: '금액',
                    width: '7%'
                },
                {
                    name: 'method',
                    text: '결제수단',
                    width: '10%'
                },
                {
                    name: 'status',
                    text: '상태',
                    width: '10%'
                },
                {
                    name: 'date',
                    text: '등록시간',
                    width: '10%',
                },
                {
                    name: 'is_change',
                    text: '변경',
                    width: '25%'
                }
            ]
        },
        orderOptions() {
            return [
                {
                    id: '오프라인',
                    name: '오프라인'
                },
                {
                    id: '온라인',
                    name: '온라인'
                },
                {
                    id: '유료회원',
                    name: '유료회원'
                }
            ]
        },
        orderStatusOptions() {
            return [
                {
                    id: 'DONE',
                    name: '결제완료'
                },
                {
                    id: 'CANCELED',
                    name: '결제취소'
                },
            ]
        },
        startDateForm() {
            return this.startDate ? `${this.Helper.dateFormatYDM(this.startDate)} 00:00:00` : '';
        },
        endDateForm() {
            return this.endDate ? `${this.Helper.dateFormatYDM(this.endDate)} 23:59:59` : '';
        }
    },
    methods: {
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }
            this.page = page;

            let params = {
                page: page,
                category: this.order,
                keyword: this.keyword,
                start_date: this.startDateForm,
                end_date: this.endDateForm,
                status: this.orderStatus,
            };

            getData(params).then(res => {
                this.payments = res.data.payments;

                this.count = res.data.count;
                this.sum = res.data.sum;

                // 뒤로가기 page에 따라 reload
                const path = `/admin/payment/${page}`
                if (this.$route.path !== path) this.$router.push(path);
            }).catch(err => {
                this.payments = [];
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
        getProgramId(data) {
            this.id = data;
        },
        handleSetOrder(order) {
            this.order = order;
        },
        handleSetStatusOrder(order) {
            this.orderStatus = order;
        },
        handleSetStartDate(date) {
            this.startDate = date;
        },
        handleSetEndDate(date) {
            this.endDate = date;
        },
    }
}
</script>

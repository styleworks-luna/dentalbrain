<template>
    <layout title="오프라인 강의 수강 신청 현황">
        <template v-slot:button>

        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="students.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>
                        <router-link :to="`/admin/user/${slotProps.row.user.id}`">
                            {{ slotProps.row.user.login_id }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.email }}</td>
                    <td>{{ slotProps.row.phone }} </td>
                    <td>
                        <template v-if="slotProps.row.payment">
                            <template v-if="slotProps.row.payment.status === 'CANCELED'">
                                결제 취소
                            </template>

                            <template v-else>
                                {{ Helper.numberWithCommas(slotProps.row.payment.totalAmount) }}원
                                <template v-if="slotProps.row.pay_status === 4"><strong class="text-danger">(환불요청)</strong></template>
                            </template>
                        </template>
                        <template v-else>
                            무료
                            <template v-if="slotProps.row.pay_status === 4"><strong class="text-danger">(환불요청)</strong></template>
                        </template>
                    </td>
                    <td>
                        <router-link :to="``"
                                     class="btn btn-info">
                            보기
                        </router-link>
                    </td>
                    <td>
                        <template v-if="slotProps.row.pay_status === 0">
                            결제 전
                        </template>
                        <template v-else-if="slotProps.row.pay_status === 1">
                            입금 대기
                        </template>
                        <template v-else-if="slotProps.row.pay_status === 3">
                            취소 완료
                        </template>
                        <template v-else-if="slotProps.row.pay_status === 4">
                            <a href="#" class="btn btn-danger text-white"
                               v-if="slotProps.row.ticket.is_free"
                               @click.prevent="cancelLecture(slotProps.row.id)">
                                신청 취소
                            </a>
                            <a href="#" class="btn btn-danger text-white"
                               v-else
                               @click.prevent="handleSetCancelLayer(slotProps.row.id, slotProps.row.payment.method)">
                                결제 취소
                            </a>
                        </template>
                        <template v-else-if="slotProps.row.pay_status === 2">
                            <a href="#" class="btn btn-danger text-white"
                               v-if="slotProps.row.ticket.is_free"
                               @click.prevent="cancelLecture(slotProps.row.id)">
                                신청 취소
                            </a>

                            <a href="#" class="btn btn-danger text-white"
                               v-else
                               @click.prevent="handleSetCancelLayer(slotProps.row.id, slotProps.row.payment.method)">
                                결제 취소
                            </a>
                        </template>
                    </td>
                    <td>{{ slotProps.row.applied_at }} </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="students" @pagination-change-page="getData" class="mb-0">
                        <span slot="prev-nav">‹</span>
                        <span slot="next-nav">›</span>
                    </pagination>
                </nav>
            </div>

            <payment-cancel-layer v-if="cancelLayer"
                                  :paymentMethod="paymentMethod"
                                  @setCancelLayer="handleSetCancelLayer"
                                  @cancelPayment="cancelPayment"></payment-cancel-layer>
        </template>
    </layout>
</template>

<script>
// component
import Table from '@/components/admin/grid/Table.vue';
import ButtonOpen from '@/components/admin/button/ButtonOpen.vue';

//api
import { Student } from '@/api/admin/lecture/Offline.js'

// mixins
import { PaymentCancelMixin } from '@/mixins/admin/payment/Cancel.js';

export default {
    name: 'AdminOfflineStatus',
    mixins: [
        PaymentCancelMixin
    ],
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen
    },
    data() {
        return {
            id: '',
            program_name: '',
            students: {
                data: []
            },
            page: 1
        }
    },
    created() {
        this.id = this.$route.params.id;
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
                    width: '8%'
                },
                {
                    name: 'user_id',
                    text: '아이디',
                    width: '12%'
                },
                {
                    name: 'email',
                    text: '이메일',
                    width: '15%'
                },
                {
                    name: 'phone',
                    text: '연락처',
                    width: '10%'
                },
                {
                    name: 'payment',
                    text: '결제금액',
                    width: '15%'
                },
                {
                    name: 'additional',
                    text: '추가정보',
                    width: '10%'
                },
                {
                    name: 'cancel',
                    text: '취소',
                    width: '15%'
                },
                {
                    name: 'started_at',
                    text: '신청일시',
                    width: '15%'
                },
            ]
        }
    },
    methods: {
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }

            let params = {
                page: page
            };

            Student.getStudentsData(this.id, params).then(res => {
                this.program_name = res.data.program_name;
                this.students = res.data.students;
            }).catch(err => {
                this.students = [];
            });
        }
    }
}
</script>

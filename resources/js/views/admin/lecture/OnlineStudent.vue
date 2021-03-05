<template>
    <layout :title="`'${program_name}' 수강 신청 현황`">
        <template v-slot:button>
            <router-link :to="`/admin/email`" class="btn btn-primary text-white">이메일 보내기</router-link>
            <router-link :to="`/admin/sns`" class="btn btn-primary text-white">sns 보내기</router-link>
        </template>

        <template v-slot:search>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <select-box class="form-control"
                                text="정렬 선택"
                                :value="order"
                                :options="orderOptions"
                                @setValue="handleSetOrder"></select-box>
                    <span class="input-group-append">
                            <button class="btn btn-primary" type="submit">검색</button>
                    </span>
                </form>
            </div>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="students.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>
                        <router-link :to="`/admin/user/${slotProps.row.user_id}`">
                            {{ slotProps.row.login_id }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.email }}</td>
                    <td>{{ slotProps.row.phone }}</td>
                    <td>
                        <template v-if="slotProps.row.status">
                            <template v-if="slotProps.row.status === 'CANCELED'">
                                결제 취소
                            </template>

                            <template v-else>
                                {{ Helper.numberWithCommas(slotProps.row.totalAmount) }}원
                            </template>
                        </template>
                        <template v-else>
                            무료
                        </template>
                    </td>
                    <td>
                        <template v-if="slotProps.row.status">
                            <template v-if="slotProps.row.status === 'CANCELED'">
                                결제 취소
                            </template>

                            <template v-else>
                                <strong class="text-danger">{{ slotProps.row.left_days }}</strong>일 남음 <template v-if="slotProps.row.is_watched">(시청함)</template>
                                <div v-if="slotProps.row.is_repeated">(재수강)</div>
                            </template>
                        </template>
                        <template v-else>
                            <strong class="text-danger">{{ slotProps.row.left_days }}</strong>일 남음
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
                        <template v-else-if="slotProps.row.pay_status === 2">
                            <a href="#" class="btn btn-danger text-white"
                               v-if="slotProps.row.is_free"
                               @click.prevent="cancelLecture(slotProps.row.id)">
                                신청 취소
                            </a>

                            <a href="#" class="btn btn-danger text-white"
                               v-else
                               @click.prevent="handleSetCancelLayer(slotProps.row.id, slotProps.row.method)">
                                결제 취소
                            </a>
                        </template>
                    </td>
                    <td>{{ slotProps.row.applied_at }}</td>
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
import SelectBox from '@/components/common/SelectBox.vue';

//api
import {Student} from '@/api/admin/lecture/Online.js';

// mixins
import {PaymentCancelMixin} from '@/mixins/admin/payment/Cancel.js';

export default {
    name: 'AdminOnlineStudent',
    mixins: [
        PaymentCancelMixin
    ],
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen,
        SelectBox,
    },
    data() {
        return {
            id: '',
            program_name: '',
            students: {
                data: []
            },
            order: 'latest',
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
                    width: '7%'
                },
                {
                    name: 'user_id',
                    text: '아이디',
                    width: '12%'
                },
                {
                    name: 'email',
                    text: '이메일',
                    width: '16%'
                },
                {
                    name: 'phone',
                    text: '연락처',
                    width: '10%'
                },
                {
                    name: 'payment',
                    text: '결제금액',
                    width: '12%'
                },
                {
                    name: 'watch',
                    text: '시청기간',
                    width: '10%'
                },
                {
                    name: 'additional',
                    text: '추가정보',
                    width: '8%'
                },
                {
                    name: 'cancel',
                    text: '취소',
                    width: '15%'
                },
                {
                    name: 'started_at',
                    text: '신청일시',
                    width: '10%'
                }
            ]
        },
        orderOptions() {
            return [
                {
                    id: 'latest',
                    name: '최신순'
                },
                {
                    id: 'login_id',
                    name: '가나다순'
                },
                {
                    id: 'left_days',
                    name: '기간순'
                },
            ]
        }
    },
    methods: {
        getData(page = this.page) {
            if (this.page) {
                page = 1;
            }

            let params = {
                page: page,
                order: this.order
            };

            Student.getStudentsData(this.id, params).then(res => {
                this.program_name = res.data.program_name;
                this.students = res.data.students;
            }).catch(err => {
                this.students = [];
            });
        },
        handleSetOrder(order) {
            this.order = order;
        }
    }
}
</script>

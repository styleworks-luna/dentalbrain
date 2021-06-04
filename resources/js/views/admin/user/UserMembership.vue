<template>
    <layout title="유료 회원정보 목록">
        <template v-slot:search>
            <div class="float-left">
                <p style="font-size: 18px;">유료회원: 명 (종료된 회원: 명)</p>
            </div>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <select-box class="form-control"
                                text="분류"
                                :value="job_name_id"
                                :options="jobOptions"
                                @setValue="handleSetJobyId"></select-box>

                    <div class="input-group">
                        <input class="form-control"
                               type="text"
                               placeholder="ID, 이름, 전화번호, 이메일"
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
                        :data="users.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.user.login_id }}</td>
                    <td>{{ slotProps.row.user.name }}</td>
                    <td>{{ slotProps.row.user.email }}</td>
                    <td>{{ slotProps.row.user.phone }}</td>
                    <td>{{ slotProps.row.user.job_name }}</td>
                    <td>{{ slotProps.row.started_at }}</td>
                    <td>{{ slotProps.row.expired_at }}</td>
                    <td>{{ slotProps.row.payment.method }}</td>
                    <td> <template v-if="slotProps.row.pay_status === 0">
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
                               v-if="slotProps.row.is_free"
                               @click.prevent="cancelLecture(slotProps.row.student_id)">
                                신청 취소
                            </a>
                            <a href="#" class="btn btn-danger text-white"
                               v-else
                               @click.prevent="handleSetCancelLayer(slotProps.row.student_id, slotProps.row.method)">
                                결제 취소
                            </a>
                        </template>
                        <template v-else-if="slotProps.row.pay_status === 2">
                            <a href="#" class="btn btn-danger text-white"
                               v-if="slotProps.row.is_free"
                               @click.prevent="cancelLecture(slotProps.row.student_id)">
                                신청 취소
                            </a>

                            <a href="#" class="btn btn-danger text-white"
                               v-else
                               @click.prevent="handleSetCancelLayer(slotProps.row.student_id, slotProps.row.method)">
                                결제 취소
                            </a>
                        </template>
                        <template v-else-if="slotProps.row.pay_status === 5">
                            <a href="#" class="btn btn-success" @click.prevent="handleSetConfirmLayer(slotProps.row.student_id)">결제 확인</a>
                            <a href="#" class="btn btn-danger text-white"
                               @click.prevent="cancelLecture(slotProps.row.student_id)">
                                신청 취소
                            </a>
                        </template>
                        <template v-else-if="slotProps.row.pay_status === 6">
                            <a href="#" class="btn btn-secondary" @click.prevent="revertConfirm(slotProps.row.student_id)">결제 완료</a>
                            <a href="#" class="btn btn-danger text-white"
                               @click.prevent="cancelLecture(slotProps.row.student_id)">
                                결제 취소
                            </a>
                        </template></td>
                    <td>{{ Helper.dateCompareWithNow(slotProps.row.started_at) > 0 ? '사용 전'
                         : Helper.dateCompareWithNow(slotProps.row.expired_at) < 0 ? '사용 후' : '사용 중' }}</td>
                    <td>
                        <router-link :to="`/admin/user/user/${slotProps.row.id}/${page}`"
                                     class="btn btn-info float-left">
                            수정
                        </router-link>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="users" @pagination-change-page="getData" class="mb-0">
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
                                   @setConfirmLayer="handleSetConfirmLayer"
                                   @confirmPayment="confirmOfflinePayment"></payment-confirm-layer>

        </template>
    </layout>
</template>


<script>
// component
import Table from '@/components/admin/grid/Table.vue';
import SelectBox from '@/components/common/SelectBox.vue';

// api
import User from '@/api/admin/user/User.js';

// mixins
import { PaymentCancelMixin } from '@/mixins/admin/payment/Cancel.js';
import {PaymentConfirmMixin} from '@/mixins/admin/payment/Confirm.js';


export default {
    name: 'AdminUser',
    components: {
        'table-grid': Table,
        'select-box': SelectBox,
    },
    mixins: [
        PaymentCancelMixin,
        PaymentConfirmMixin,
    ],
    data() {
        return {
            users: {
                data: []
            },
            member: '',
            jobOptions: [],
            job_name_id: '',
            keyword: '',
            page: this.$route.params.page || 1
        }
    },
    mounted() {
        this.getData();
        this.getCategory();
    },
    computed: {
        tableCol() {
            return [
                {
                    name: 'id',
                    text: '번호',
                    width: '4%'
                },
                {
                    name: 'login_id',
                    text: '아이디',
                    width: '9%'
                },
                {
                    name: 'name',
                    text: '이름',
                    width: '7%'
                },
                {
                    name: 'email',
                    text: '이메일',
                    width: '12%'
                },
                {
                    name: 'phone',
                    text: '전화번호',
                    width: '10%'
                },
                {
                    name: 'job_id',
                    text: '직업군',
                    width: '10%'
                },
                {
                    name: 'started_at',
                    text: '시작일',
                    width: '11%',
                },
                {
                    name: 'ended_at',
                    text: '종료일',
                    width: '11%',
                },
                {
                    name: 'method',
                    text: '결제수단',
                    width: '6%',
                },
                {
                    name: 'status',
                    text: '결제상태',
                    width: '6%',
                },
                {
                    name: 'membership_status',
                    text: '상태',
                    width: '7%',
                },
                {
                    name: 'edit',
                    text: '정보수정',
                    width: '7%'
                }
            ]
        },
        userOption() {
            return [
                {
                    id: 0,
                    name: '일반회원',
                },
                {
                    id: 1,
                    name: '유료회원',
                }
            ]
        },
    },
    methods: {
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }
            this.page = page;

            let params = {
                job_name_id: this.job_name_id,
                is_paid: this.member,
                keyword: this.keyword,
                page: page
            };

            User.getMembership(params).then(res => {
                this.users = res.data[0];
                // 뒤로가기 page에 따라 reload
                const path = `/admin/user/membership/${page}`
                if (this.$route.path !== path) this.$router.push(path);
            }).catch(err => {
                this.users = [];
            });
        },
        getCategory() {
            User.getCategory().then(res => {
                this.jobOptions = res.data.userJob;
            });
        },
        handleSetMember(value) {
            this.member = value;
        },
        handleSetJobyId(value) {
            this.job_name_id = value;
        },
        handleSetStatus(id) {
            User.setStatus(id).then(res => {
                this.getData();
                alert(res.data.msg);
            })
        }
    }
}
</script>

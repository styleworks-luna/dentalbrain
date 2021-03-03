<template>
    <layout :title="`'${program_name}' 수강 신청 현황`">
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
                    <td>{{ slotProps.row.phone }}</td>
                    <td>
                        <template v-if="slotProps.row.payment">
                            <template v-if="slotProps.row.payment.status === 'CANCELED'">
                                결제 취소
                            </template>

                            <template v-else>
                                {{ Helper.numberWithCommas(slotProps.row.payment.totalAmount) }}원
                            </template>
                        </template>
                        <template v-else>
                            무료
                        </template>
                    </td>
                    <td>
                        <template v-if="slotProps.row.payment">
                            <template v-if="slotProps.row.payment.status === 'CANCELED'">
                                결제 취소
                            </template>

                            <template v-else>
                                {{ slotProps.row.left_days }}일 남음
                            </template>
                        </template>
                        <template v-else>
                            무료
                        </template>
                    </td>
                    <td>
                        <router-link :to="``"
                                     class="btn btn-info">
                            보기
                        </router-link>
                    </td>
                    <td>
                        <template v-if="slotProps.row.pay_status === 3">
                            취소 완료
                        </template>
                        <a href="#" class="btn btn-danger text-white"
                           @click.prevent="handleSetCancelLayer(slotProps.row.id, slotProps.row.method)"
                           v-else>
                            결제 취소
                        </a>
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
import PaymentCancelLayer from '@/components/admin/form/PaymentCancelLayer.vue';

//api
import { Student } from '@/api/admin/lecture/Online.js'

export default {
    name: 'AdminOnlineStudent',
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen,
        'payment-cancel-layer': PaymentCancelLayer
    },
    data() {
        return {
            id: '',
            program_name: '',
            students: {
                data: []
            },
            cancelLayer: false,
            cancelStudentId: '',
            paymentMethod: ''
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
        }
    },
    methods: {
        getData(page = this.page) {
            if (this.page) {
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
        },
        handleSetCancelLayer(studentId, paymentMethod) {
            this.cancelLayer = !this.cancelLayer;
            this.cancelStudentId = studentId || '';
            this.paymentMethod = paymentMethod || '';
        },
        cancelPayment(params) {
            Student.cancelPayment(this.id, this.cancelStudentId, params).then(res => {
                alert(res.data.msg);
                this.getData();
            }).catch(err => {
                alert('오류');
            })
        }
    }
}
</script>

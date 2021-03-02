<template>
    <layout title="결제정보">
        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="payments.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>
                        {{ slotProps.row.student.ticket.program.is_online ? '온라인' : '오프라인' }}
                    </td>
                    <td>
                        <a :href="Helper.urlFormat(`/lectures/${slotProps.row.student.ticket.program.id}`)">
                            {{ slotProps.row.student.ticket.program.title }}
                        </a>
                    </td>
                    <td>
                        <br>
                        {{ slotProps.row.student.email }}
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
                    <td>

                    </td>
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
        </template>
    </layout>
</template>

<script>
// component
import Table from '@/components/admin/grid/Table.vue';

//api
import Payment from '@/api/admin/payment/Payment.js'

export default {
    name: 'AdminPayment',
    components: {
        'table-grid': Table
    },
    data() {
        return {
            payments: {
                data: []
            },
            page: 1
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
                    width: '6%'
                },
                {
                    name: 'category',
                    text: '구분',
                    width: '9%'
                },
                {
                    name: 'title',
                    text: '제목',
                    width: '33%'
                },
                {
                    name: 'user',
                    text: '결제자',
                    width: '10%'
                },
                {
                    name: 'price',
                    text: '금액',
                    width: '8%'
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
                    width: '13%'
                }
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

            Payment.getData(params).then(res => {
                this.payments = res.data.payments;
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
            }
        }
    }
}
</script>

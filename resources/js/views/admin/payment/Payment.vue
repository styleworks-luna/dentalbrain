<template>
    <layout title="결제정보">
        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="payments.data">
                <template v-slot:list="slotProps">

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

export default {
    name: 'AdminOffline',
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
    computed: {
        tableCol() {
            return [
                {
                    name: 'id',
                    text: '번호'
                },
                {
                    name: 'category',
                    text: '구분'
                },
                {
                    name: 'title',
                    text: '제목'
                },
                {
                    name: 'user',
                    text: '결제자'
                },
                {
                    name: 'price',
                    text: '금액'
                },
                {
                    name: 'method',
                    text: '결제수단'
                },
                {
                    name: 'status',
                    text: '상태'
                },
                {
                    name: 'date',
                    text: '등록시간'
                },
                {
                    name: 'is_change',
                    text: '변경'
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

            Faq.getData(params).then(res => {
                this.lectures = res.data.payment;
            }).catch(err => {
                this.lectures = [];
            });
        },
    }
}
</script>

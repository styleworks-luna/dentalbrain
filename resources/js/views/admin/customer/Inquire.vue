<template>
    <layout title="문의하기">
        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="inquirys.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{slotProps.row.category}}</td>
                    <td>
                        <router-link :to="`/admin/customer/inquiry/${slotProps.row.id}`">
                            {{ slotProps.row.title }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.name }}</td>
                    <td>{{ slotProps.row.created_at }}</td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="inquirys" @pagination-change-page="getData" class="mb-0">
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
import ButtonOpen from '@/components/admin/button/ButtonOpen.vue';

// api
import Inquiry from '@/api/admin/customer/Inquiry.js';

export default {
    name: 'AdminInquiry',
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen
    },
    data() {
        return {
            inquirys: {
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
                    name: 'name',
                    text: '이름'
                },
                {
                    name: 'created_at',
                    text: '작성일'
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

            Inquiry.getData(params).then(res => {
                this.inquirys = res.data.inquiry;
            }).catch(err => {
                this.inquirys = [];
            });
        },
    }
}
</script>

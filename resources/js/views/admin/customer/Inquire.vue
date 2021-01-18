<template>
    <layout title="문의내역">
        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="inquires.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{slotProps.row.category}}</td>
                    <td>
                        <router-link :to="`/admin/customer/inquire/${slotProps.row.id}`">
                            {{ slotProps.row.title }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.name }}</td>
                    <td>{{ slotProps.row.created_at }}</td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="inquires" @pagination-change-page="getData" class="mb-0">
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
import Inquire from '@/api/admin/customer/Inquire.js';

export default {
    name: 'AdminInquire',
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen
    },
    data() {
        return {
            inquires: {
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

            Inquire.getData(params).then(res => {
                console.log(res);
                this.inquires = res.data.inquiry;
            }).catch(err => {
                this.inquires = [];
            });
        },
    }
}
</script>

<template>
    <layout title="FAQ">
        <template v-slot:button>
            <router-link to="/admin/customer/faq/create"
                         class="btn btn-lg btn-info">
                FAQ 추가
            </router-link>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="faqs.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>
                        <router-link :to="`/admin/customer/faq/${slotProps.row.id}`">
                            {{ slotProps.row.question }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.created_at }}</td>
                    <td>
                        <button-open :isOpen="slotProps.row.is_open"
                                     class="btn-block"
                                     @setStatus="handleSetStatus(slotProps.row.id)"></button-open>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="faqs" @pagination-change-page="getData" class="mb-0">
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
    import Faq from '@/api/admin/customer/Faq.js';

    export default {
        name: 'AdminFaq',
        components: {
            'table-grid': Table,
            'button-open': ButtonOpen
        },
        data() {
            return {
                faqs: {
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
                        name: 'question',
                        text: '제목'
                    },
                    {
                        name: 'created_at',
                        text: '작성일'
                    },
                    {
                        name: 'is_open',
                        text: '상태',
                        isSort: true
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
                    this.faqs = res.data.faq;
                }).catch(err => {
                    this.faqs = [];
                });
            },
            handleSetStatus(id) {
                Faq.setStatus(id).then(res => {
                    this.getData();
                    alert(res.data.msg);
                })
            }
        }
    }
</script>

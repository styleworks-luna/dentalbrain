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
                        :data="data">
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
                                     @setStatus="handleSetStatus(slotProps.row.id)"></button-open>
                    </td>
                </template>
            </table-grid>

            <router-view></router-view>
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
                data: []
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
            getData() {
                Faq.getData().then(res => {
                    this.data = res.data.faq.data;
                }).catch(err => {
                    this.data = [];
                });
            },
            handleSetStatus(id) {
                Faq.setStatus(id).then(res => {
                    this.getData();
                    alert(res.data.msg);
                }).catch(err => {
                    alert('오류');
                })
            }
        }
    }
</script>

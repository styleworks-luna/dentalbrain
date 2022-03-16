<template>
    <layout title="FAQ">
        <template v-slot:button>
            <router-link to="/admin/customer/faq/create"
                         class="btn btn-lg btn-info">
                FAQ 추가
            </router-link>
        </template>

        <template v-slot:search>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <div class="input-group">
                        <input class="form-control"
                               type="text"
                               placeholder="제목, 내용"
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
                        :data="faqs.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>
                        <router-link :to="`/admin/customer/faq/${slotProps.row.id}/${page}`">
                            {{ slotProps.row.question }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.created_at }}</td>
                    <td>
                        <button-open :isOpen="slotProps.row.is_open"
                                     class="btn-block  btn-outline-dark"
                                     @setStatus="handleSetStatus(slotProps.row.id)"></button-open>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="faqs" :limit=3 @pagination-change-page="getData" class="mb-0">
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
                keyword: '',
                page: this.$route.params.page || 1
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
                        width: '10%'
                    },
                    {
                        name: 'question',
                        text: '제목',
                        width: '60%'
                    },
                    {
                        name: 'created_at',
                        text: '작성일',
                        width: '20%'
                    },
                    {
                        name: 'is_open',
                        text: '상태',
                        width: '10%',
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
                    keyword: this.keyword,
                    page: page
                };

                Faq.getData(params).then(res => {
                    this.faqs = res.data.faq;
                    // 뒤로가기 page에 따라 reload
                    const path = `/admin/customer/faq/${page}`
                    if (this.$route.path !== path) this.$router.push(path);
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

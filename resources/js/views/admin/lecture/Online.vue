<template>
    <layout title="온라인 강의">
        <template v-slot:button>
            <router-link to="/admin/lecture/online/create"
                         class="btn btn-lg btn-info">
                온라인 강의 관리
            </router-link>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="lectures.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.major_category_name }}</td>
                    <td>{{ slotProps.row.minor_category_name }}</td>
                    <td>{{ slotProps.row.title }} </td>
                    <td>
                        {{ slotProps.row.students_count }}명
                        <router-link :to="``"
                                    class="btn btn-info ml-4">
                            보기
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="`/admin/lecture/online/${slotProps.row.id}`"
                                     class="btn btn-warning text-white mr-3">
                            수정</router-link>
                        <button-open :isOpen="slotProps.row.is_open"
                                     class="btn-danger text-white border-danger"
                                     @setStatus="handleSetStatus(slotProps.row.id)"></button-open>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="lectures" @pagination-change-page="getData" class="mb-0">
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

    //api
    import Online from '@/api/admin/lecture/Online.js'

    export default {
        name: 'AdminOnline',
        components: {
            'table-grid': Table,
            'button-open': ButtonOpen
        },
        data() {
            return {
                lectures: {
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
                        text: '대분류'
                    },
                    {
                        name: 'subclass',
                        text: '소분류'
                    },
                    {
                        name: 'title',
                        text: '강의 제목'
                    },
                    {
                        name: 'count',
                        text: '수강현황'
                    },
                    {
                        name: 'control',
                        text: '수정'
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

                Online.getData(params).then(res => {
                    this.lectures = res.data.programs;
                }).catch(err => {
                    this.lectures = [];
                });
            },
            handleSetStatus(id) {
                Online.setStatus(id).then(res => {
                    this.getData();
                    alert(res.data.msg);
                })
            }
        }
    }
</script>

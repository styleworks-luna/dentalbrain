<template>
    <layout title="온라인 강의">
        <template v-slot:button>
            <router-link to="/admin/lecture/online/create"
                         class="btn btn-lg btn-info">
                온라인 강의 관리
            </router-link>
        </template>

        <template v-slot:search>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <select-box class="form-control"
                                text="종류 선택"
                                :value="major_category_id"
                                :options="majorCategoryOptions"
                                @setValue="handleSetMajorCategoryId"></select-box>

                    <select-box class="form-control"
                                text="종류 선택"
                                :value="minor_category_id"
                                :options="minorCategoryOptions"
                                @setValue="handleSetMinorCategoryId"></select-box>

                    <div class="input-group">
                        <input class="form-control"
                               type="text"
                               placeholder="제목"
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
                        :data="lectures.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.major_category_name }}</td>
                    <td>{{ slotProps.row.minor_category_name }}</td>
                    <td>{{ slotProps.row.title }} </td>
                    <td>
                        {{ slotProps.row.students_count }}명
                        <router-link :to="`/admin/lecture/online/${slotProps.row.id}/student`"
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
                                     @setStatus="handleSetStudent(slotProps.row.id)"></button-open>
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
    import SelectBox from '@/components/common/SelectBox.vue';

    //api
    import Online from '@/api/admin/lecture/Online.js';

    // mixins
    import { ProgramCategoryMixin } from '@/mixins/admin/lecture/Form.js';

    export default {
        name: 'AdminOnline',
        mixins: [
            ProgramCategoryMixin
        ],
        components: {
            'table-grid': Table,
            'button-open': ButtonOpen,
            'select-box':SelectBox,
        },
        data() {
            return {
                lectures: {
                    data: []
                },
                page: 1,
                keyword: ''
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
                    page: page,
                    keyword: this.keyword,
                    major_category_id: this.major_category_id,
                    minor_category_id: this.minor_category_id,
                };
                Online.getData(params).then(res => {
                    this.lectures = res.data.programs;
                }).catch(err => {
                    this.lectures = [];
                });
            },
            handleSetStudent(id) {
                Online.setStudent(id).then(res => {
                    this.getData();
                    alert(res.data.msg);
                })
            },
        }
    }
</script>

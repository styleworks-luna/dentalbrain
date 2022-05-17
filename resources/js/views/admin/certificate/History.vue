<template>
    <layout title="발급 내역">
        <template v-slot:search>
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0" style="font-size: 12px">발급내역 (자격증 {{  }}건 | 수료증 {{  }}건) ]</p>
                <div>
                    <form @submit.prevent="getData">
                        <select-box class="form-control"
                                    text="구분"
                                    :value="category_id"
                                    :options="CategoryOptions"
                                    @setValue="handleSetCategoryId"></select-box>

                        <div class="input-group">
                            <input class="form-control"
                                   type="text"
                                   placeholder="제목,강의명,ID,이름 검색"
                                   v-model="keyword">
                            <span class="input-group-append">
                            <button class="btn btn-primary" type="submit">검색</button>
                        </span>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="history.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.type }}</td>
                    <td>{{ slotProps.row.title }}</td>
                    <td>{{ slotProps.row.program_title }}</td>
                    <td>{{ slotProps.row.login_id }}</td>
                    <td>{{ slotProps.row.name }}</td>
                    <td>{{ slotProps.row.email }}</td>
                    <td>{{ slotProps.row.phone }}</td>
                    <td>
                        <template v-if="slotProps.row.type == '자격증'">
                            <a :href="`/certificate/pdf/program/${slotProps.row.program_id}/user/${slotProps.row.user_id}/qualification`"
                               class="btn btn-info">
                                보기
                            </a>
                        </template>
                        <template v-if="slotProps.row.type == '수료증'">
                            <a :href="`/certificate/pdf/program/${slotProps.row.program_id}/user/${slotProps.row.user_id}/completion`"
                               class="btn btn-info">
                                보기
                            </a>
                        </template>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="history" :limit=3 @pagination-change-page="getData()" class="mb-0">
                        <span slot="prev-nav">‹</span>
                        <span slot="next-nav">›</span>
                    </pagination>
                </nav>
            </div>
        </template>
    </layout>
</template>

<script>
import Table from '@/components/admin/grid/Table.vue';
import ButtonOpen from '@/components/admin/button/ButtonOpen.vue';
import SelectBox from '@/components/common/SelectBox.vue';

import Certificate from '@/api/admin/certificate/Certificate.js';

export default {
    name: "History",
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen,
        'select-box': SelectBox,
    },
    computed: {
        tableCol() {
            return [
                {
                    name: 'id',
                    text: '번호',
                    width: '5%'
                },
                {
                    name: 'category',
                    text: '구분',
                    width: '6%'
                },
                {
                    name: 'title',
                    text: '증명서제목',
                    width: '10%'
                },
                {
                    name: 'lecture_name',
                    text: '강의명',
                    width: '10%'
                },
                {
                    name: 'user_id',
                    text: 'ID',
                    width: '5%'
                },
                {
                    name: 'name',
                    text: '이름',
                    width: '8%'
                },
                {
                    name: 'email',
                    text: '이메일',
                    width: '8%'
                },
                {
                    name: 'phone',
                    text: '연락처',
                    width: '8%'
                },
                {
                    name: 'public',
                    text: '보기',
                    width: '5%'
                },
            ]
        },
        CategoryOptions() {
            return [
                {
                    id: 'qualification',
                    name: '자격증'
                },
                {
                    id: 'completion',
                    name: '수료증'
                }
            ]
        }
    },
    data() {
        return {
            history: {
                data:[]
            },
            keyword: "",
            category_id: "",
            page: '',
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            let params = {
                keyword: this.keyword,
                category: this.category_id,
                page: this.page,
            }
            Certificate.getHistoryData(params).then(res => {
                this.history = res.data.result;
            })
        },
        handleSetCategoryId(id) {
            this.category_id = id;
        },
    }
}
</script>

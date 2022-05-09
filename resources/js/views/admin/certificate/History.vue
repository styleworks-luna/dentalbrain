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
                        :data="completion.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.status }}</td>
                    <td>{{ slotProps.row.title }}</td>
                    <td>{{ slotProps.row.lecture_title }}</td>
                    <td>{{ slotProps.row.user_id }}</td>
                    <td>{{ slotProps.row.user_name }}</td>
                    <td>{{ slotProps.row.user_email }}</td>
                    <td>{{ slotProps.row.user_phone }}</td>
                    <td>
                        <a :href="`/certificate/certificate/${slotProps.row.id}`"
                           class="btn btn-info">
                            보기
                        </a>
                    </td>
                </template>
            </table-grid>

            <!--<div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="recruitList" :limit=3 @pagination-change-page="" class="mb-0">
                        <span slot="prev-nav">‹</span>
                        <span slot="next-nav">›</span>
                    </pagination>
                </nav>
            </div>-->
        </template>
    </layout>
</template>

<script>
import Table from '@/components/admin/grid/Table.vue';
import ButtonOpen from '@/components/admin/button/ButtonOpen.vue';
import SelectBox from '@/components/common/SelectBox.vue';

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
                    id: '1',
                    name: '자격증'
                },
                {
                    id: '0',
                    name: '수료증'
                }
            ]
        }
    },
    data() {
        return {
            completion: {
                data: [
                    {
                        id: 11,
                        status: '자격증',
                        title: '증명서 제목',
                        lecture_title: '강의 제목',
                        user_id: 'test',
                        user_name: '홍길동',
                        user_email: 'test@example.com',
                        user_phone: '01093737194',
                    }
                ],
            },
            keyword: "",
            category_id: "",
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            let params = {
                keyword: this.keyword,
                category: this.category_id
            }
        },
        handleSetCategoryId(id) {
            this.category_id = id;
        },
    }
}
</script>

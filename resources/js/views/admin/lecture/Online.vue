<template>
    <layout title="온라인 강의">
        <template v-slot:button>
            <router-link to="/admin/lecture/online/create"
                         class="btn btn-lg btn-info">
                온라인 강의 관리
            </router-link>
        </template>

        <template v-slot:search>
            <span style="font-size: 12px">강의현황 (공개 {{ stats.publicCount }}개 / 비공개 {{ stats.privateCount }}개) | 수강자 없는 강의 {{
                    stats.noStudent
                }}개</span>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <select-box class="form-control"
                                text="증명서 구분"></select-box>

                    <select-box class="form-control"
                                text="대분류 선택"
                                :value="major_category_id"
                                :options="majorCategoryOptions"
                                @setValue="handleSetMajorCategoryId"></select-box>

                    <select-box class="form-control"
                                text="소분류 선택"
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
                    <td>
                        <a :href="Helper.urlFormat(`/lectures/${slotProps.row.id}`)" target="_blank">
                            {{ slotProps.row.title }}
                        </a>
                    </td>
                    <td >
                        <template v-if="(slotProps.row.completion_id != null) || (slotProps.row.qualification_id != null)">
                            {{ slotProps.row.certificate_qualification != null ?
                            slotProps.row.certificate_qualification.title : '' }}
                            /
                            {{ slotProps.row.certificate_completion != null ?
                            slotProps.row.certificate_completion.title : '' }}
                        </template>
                    </td>
                    <td>
                        <template v-if="(slotProps.row.completion_id != null) || (slotProps.row.qualification_id != null)">
                            {{ slotProps.row.completion_count + slotProps.row.qualification_count }} 명
                            <router-link :to="`/admin/certificate/lecture/${slotProps.row.id}`"
                                         class="btn btn-info ml-2">
                                보기
                            </router-link>
                        </template>
                    </td>
                    <td>
                        {{ slotProps.row.students_count }}명
                        <router-link :to="`/admin/lecture/online/${slotProps.row.id}/student`"
                                     class="btn btn-info ml-2">
                            보기
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="`/admin/lecture/online/${slotProps.row.id}/${page}`"
                                     class="btn btn-warning text-white mr-2">
                            수정
                        </router-link>
                        <button-open :isOpen="slotProps.row.is_open"
                                     class="btn-danger text-white border-danger mr-2"
                                     @setStatus="handleSetStatus(slotProps.row.id)"></button-open>
                        <router-link :to="`/admin/lecture/online/${slotProps.row.id}/duplicate/${page}`"
                                     class="btn btn-success text-white mr-2">
                            복사
                        </router-link>
                        <button class="btn btn-danger" @click="destroy(slotProps.row.id)">삭제</button>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="lectures" :limit=3 @pagination-change-page="getData" class="mb-0">
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
import {Online} from '@/api/admin/lecture/Online.js';

// mixins
import {ProgramCategoryMixin} from '@/mixins/admin/lecture/Form.js';

export default {
    name: 'AdminOnline',
    mixins: [
        ProgramCategoryMixin
    ],
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen,
        'select-box': SelectBox,
    },
    data() {
        return {
            lectures: {
                data: []
            },
            page: this.$route.params.page || 1,
            keyword: '',
            stats: [],
        }
    },
    mounted() {
        this.getData();
        this.getStats();
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
                    text: '대분류',
                    width: '6%'
                },
                {
                    name: 'subclass',
                    text: '소분류',
                    width: '6%'
                },
                {
                    name: 'title',
                    text: '강의 제목',
                    width: '30%'
                },
                {
                    name: 'certificate_title',
                    text: '증명서 제목',
                    width: '10%'
                },
                {
                    name: 'certificate_status',
                    text: '증명서 신청 현황',
                    width: '10%'
                },
                {
                    name: 'count',
                    text: '수강현황',
                    width: '10%'
                },
                {
                    name: 'control',
                    text: '수정',
                    width: '25%'
                },
            ]
        }
    },
    methods: {
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }
            this.page = page;

            let params = {
                page: page,
                keyword: this.keyword,
                major_category_id: this.major_category_id,
                minor_category_id: this.minor_category_id,
            };
            Online.getData(params).then(res => {
                this.lectures = res.data.programs;
                console.log(this.lectures);
                // 뒤로가기 page에 따라 reload
                const path = `/admin/lecture/online/${page}`
                if (this.$route.path !== path) this.$router.push(path);
            }).catch(err => {
                this.lectures = [];
            });
        },
        getStats() {
            Online.getStats().then(res => {
                this.stats = res.data;
            }).catch(err => {
                this.lectures = [];
            });
        },
        handleSetStatus(id) {
            Online.setStatus(id).then(res => {
                this.getData();
                alert('수정되었습니다.');
            })
        },
        handleSetStudent(id) {
            Online.setStudent(id).then(res => {
                this.getData();
                alert(res.data.msg);
            })
        },
        destroy(id) {
            Online.destroy(id).then(res => {
                alert(res.data.msg);
                window.location.reload();
            })
        }
    }
}
</script>

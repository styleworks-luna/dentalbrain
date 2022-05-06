<template>
    <layout title="'개설 된 강의 제목' 증명서 신청 현황">
        <template v-slot:button>
            <router-link to="/admin/certificate/create/certificate/"
                         class="btn btn-lg btn-info">
                엑셀 다운로드
            </router-link>
            <router-link to="/admin/certificate/create/completion/"
                         class="btn btn-lg btn-info">
                일괄 합격
            </router-link>
            <router-link to="/admin/certificate/create/completion/"
                         class="btn btn-lg btn-info">
                일괄 발급
            </router-link>
        </template>
        <template v-slot:search>
            <div class="d-flex justify-content-between align-items-center">
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
                                   placeholder="이름, 이메일, 연락처, 대학교"
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
                        :data="recruitList.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.company_name }}</td>
                    <td>{{ slotProps.row.applied_resumes_count }}</td>
                    <td>{{ slotProps.row.applied_resumes_count }}</td>
                    <td>{{ slotProps.row.applied_resumes_count }}</td>
                    <td>{{ slotProps.row.applied_resumes_count }}</td>
                    <td>{{ slotProps.row.applied_resumes_count }}</td>
                    <td>{{ slotProps.row.applied_resumes_count }}</td>
                    <td>{{ slotProps.row.applied_resumes_count }}</td>
                    <td>{{ slotProps.row.applied_resumes_count }}</td>
                    <td>대기
                        <router-link :to="`/admin/lecture/online/${slotProps.row.id}/student`"
                                     class="btn btn-info ml-2">
                            변경
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="`/admin/lecture/online/${slotProps.row.id}/student`"
                                     class="btn btn-info ml-2">
                            발급
                        </router-link>
                    </td>
                    <td>
                        <button class="btn btn-danger" @click="popupControl(slotProps.row.id)">수정</button>
                    </td>
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
import Recruit from '@/api/admin/albatalk/Recruit.js';
import Table from '@/components/admin/grid/Table.vue';
import ButtonOpen from '@/components/admin/button/ButtonOpen.vue';
import SelectBox from '@/components/common/SelectBox.vue';

export default {
    name: "LectureCertificate",
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
                    width: '5%'
                },
                {
                    name: 'id',
                    text: '아이디',
                    width: '5%'
                },
                {
                    name: 'name',
                    text: '이름',
                    width: '5%'
                },
                {
                    name: 'email',
                    text: '이메일',
                    width: '10%'
                },
                {
                    name: 'phone',
                    text: '연락처',
                    width: '10%'
                },
                {
                    name: 'birth',
                    text: '생년월일',
                    width: '10%'
                },
                {
                    name: 'school',
                    text: '대학교',
                    width: '7%'
                },
                {
                    name: 'number',
                    text: '학번',
                    width: '7%'
                },
                {
                    name: 'score',
                    text: '점수',
                    width: '5%'
                },
                {
                    name: 'certificate_pass',
                    text: '합격여부',
                    width: '10%'
                },
                {
                    name: 'certificate_issued',
                    text: '증명서 발급',
                    width: '7%'
                },
                {
                    name: 'edit',
                    text: '수정',
                    width: '7%'
                },
                {
                    name: 'detail',
                    text: '증명서보기',
                    width: '7%'
                },

            ]
        },
        CategoryOptions() {
            return [
                {
                    id: '1',
                    name: '진행중'
                },
                {
                    id: '0',
                    name: '종료'
                }
            ]
        }
    },
    data() {
        return {
            recruitList: {
                data: [],
            },
            stats: [],
            keyword: "",
            category_id: "",
        }
    },
    mounted() {
        this.getData();
        this.getStats();
    },
    methods: {
        getData() {
            let params = {
                keyword: this.keyword,
                ongoing: this.category_id
            }
            Recruit.getData(params).then(res => {
                this.recruitList = res.data;
            }).catch(err => {
                this.recruitList = {};
            });
        },
        handleSetCategoryId(id) {
            this.category_id = id;
        },
        handleSetStatus(id) {
            Recruit.setStatus(id).then(res => {
                this.getData();
                alert('수정되었습니다.');
            })
        },
        getStats(){
            Recruit.getStats().then(res => {
                this.stats = res.data;
            })
        }
    }
}
</script>

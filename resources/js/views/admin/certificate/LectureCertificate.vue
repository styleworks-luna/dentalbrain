<template>
    <layout title="'개설 된 강의 제목' 증명서 신청 현황">
        <template v-slot:button>
            <a :href="`/api/admin/lecture/${program_id}/certificate/excel`"
                         class="btn btn-lg btn-info">
                엑셀 다운로드
            </a>
            <button class="btn btn-lg btn-info" @click.prevent="allPass">
                일괄 합격
            </button>
            <button class="btn btn-lg btn-info" @click.prevent="allIssue">
                일괄 발급
            </button>
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
                        :data="lectureCertificationList.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.num }}</td>
                    <td>{{ slotProps.row.type }}</td>
                    <td>{{ slotProps.row.login_id }}</td>
                    <td>{{ slotProps.row.name }}</td>
                    <td>{{ slotProps.row.email }}</td>
                    <td>{{ slotProps.row.phone }}</td>
                    <td>{{ slotProps.row.birthday }}</td>
                    <td>{{ slotProps.row.university }}</td>
                    <td>{{ slotProps.row.score }}</td>
                    <td>{{ slotProps.row.student_number }}</td>
                    <td>
                        <template v-if="slotProps.row.status == 2">대기중</template>
                        <template v-else-if="slotProps.row.status == 3">불합격</template>
                        <template v-else-if="slotProps.row.status == 4">합격</template>
                        <template v-if="slotProps.row.type == '자격증'">
                            <select @change="handleCertificatePass(slotProps.row.id, $event)" class="form-control" v-model="slotProps.row.status">
                                <option value=2>대기중</option>
                                <option value=3>불합격</option>
                                <option value=4>합격</option>
                            </select>
                        </template>
                        <template v-if="slotProps.row.type =='수료증'">
                            <select @change="handleCompletionPass(slotProps.row.id, $event)" class="form-control" v-model="slotProps.row.status">
                                <option value=2>대기중</option>
                                <option value=3>불합격</option>
                                <option value=4>합격</option>
                            </select>
                        </template>
                    </td>
                    <td>
                        <template v-if="slotProps.row.status == 4 || slotProps.row.status == 3">
                            <template v-if="slotProps.row.is_issued">
                                발급 완료
                            </template>
                            <template v-else>
                                <template v-if="slotProps.row.type == '자격증'">
                                    <button class="btn btn-info" @click="handleCertificateIssue(slotProps.row.id)">발급</button>
                                </template>
                                <template v-if="slotProps.row.type == '수료증'">
                                    <button class="btn btn-info"  @click="handleCompletionIssue(slotProps.row.id)">발급</button>
                                </template>
                            </template>
                        </template>
                    </td>
                    <td>
                        <button class="btn btn-danger" @click="popupControl(slotProps.row.id, slotProps.row.type)">수정</button>
                    </td>
                    <td>
                        <template v-if="slotProps.row.type == '자격증'">
                            <a :href="`/certificate/pdf/program/${program_id}/user/${slotProps.row.user_id}/qualification`"
                               target="_blank"
                               class="btn btn-info">
                                보기
                            </a>
                        </template>
                        <template v-if="slotProps.row.type == '수료증'">
                            <a :href="`/certificate/pdf/program/${program_id}/user/${slotProps.row.user_id}/completion`"
                               target="_blank"
                               class="btn btn-info">
                                보기
                            </a>
                        </template>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="lectureCertificationList" :limit=3 @pagination-change-page="getData" class="mb-0">
                        <span slot="prev-nav">‹</span>
                        <span slot="next-nav">›</span>
                    </pagination>
                </nav>
            </div>
        </template>

        <template v-slot:footer>
            <LectureCertificatePopup v-if="showPopup" :id="popupId" :type="popType" :program_id="program_id" @close="popupClose"/>
        </template>
    </layout>
</template>

<script>
import Table from '@/components/admin/grid/Table.vue';
import ButtonOpen from '@/components/admin/button/ButtonOpen.vue';
import SelectBox from '@/components/common/SelectBox.vue';
import LectureCertificatePopup from '@/views/admin/certificate/LectureCertificatePopup.vue';

import LectureCertificates from '@/api/admin/certificate/LectureCertificates.js';

export default {
    name: "LectureCertificate",
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen,
        'select-box': SelectBox,
        LectureCertificatePopup,
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
                    name: 'login_id',
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
                    width: '8%'
                },
                {
                    name: 'birth',
                    text: '생년월일',
                    width: '8%'
                },
                {
                    name: 'school',
                    text: '대학교',
                    width: '10%'
                },
                {
                    name: 'score',
                    text: '점수',
                    width: '6%'
                },
                {
                    name: 'number',
                    text: '학번',
                    width: '7%'
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
        },
        statusOptions() {
            return [
                {
                    id: 2,
                    name: '대기중'
                },
                {
                    id: 3,
                    name: '불합격'
                },
                {
                    id: 4,
                    name: '합격'
                }
            ]
        }
    },
    created() {
        this.program_id = this.$route.params.id;
    },
    data() {
        return {
            lectureCertificationList: {
                data: [],
            },
            keyword: "",
            category_id: "",
            showPopup: false,
            showSelected: false,
            popupId: 0,
            popType: '',
            page: 1,
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
            LectureCertificates.getData(this.program_id,params).then(res => {
                this.lectureCertificationList = res.data;
            })
        },
        allPass() {
          let params = {
              keyword: this.keyword,
              category: this.category_id,
          }
          LectureCertificates.handleAllPass(this.program_id, params).then(res => {
              alert(res.data.msg);
              this.getData();
          })
        },
        handleCertificatePass(certificate_id, event) {
            let params = {
                status: event.target.value,
            }
            LectureCertificates.handleCertificatePass(certificate_id, params).then(res => {
                alert(res.data.msg);
                this.getData();
            })
        },
        handleCompletionPass(certificate_id, event) {
            let params = {
                status: event.target.value,
            }
            LectureCertificates.handleCompletionPass(certificate_id, params).then(res => {
                alert(res.data.msg);
                this.getData();
            })
        },
        allIssue() {
            let params = {
                keyword: this.keyword,
                category: this.category_id,
            }
            LectureCertificates.handleAllIssue(this.program_id, params).then(res => {
                alert(res.data.msg);
                this.getData();
            })
        },
        handleCertificateIssue(certificate_id) {
            LectureCertificates.handleCertificateIssue(certificate_id).then(res => {
                alert(res.data.msg);
                this.getData();
            })
        },
        handleCompletionIssue(certificate_id) {
            LectureCertificates.handleCompletionIssue(certificate_id).then(res => {
                alert(res.data.msg);
                this.getData();
            })
        },
        handleSetCategoryId(categoryId) {
            this.category_id = categoryId;
        },
        popupControl(popupId, popType) {
            this.popupId = popupId;
            this.popType = popType;
            this.showPopup = true;
        },
        popupClose(show) {
            this.showPopup = show;
        }
    }
}
</script>

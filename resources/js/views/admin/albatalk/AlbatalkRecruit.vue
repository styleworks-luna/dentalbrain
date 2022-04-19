<template>
    <layout title="구인 정보">
        <template v-slot:search>
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0" style="font-size: 12px">구인등록 정보 [전체 0개 (진행중 0건 | 종료 0건) ]</p>
                <div>
                    <form @submit.prevent="getData">
                        <select-box class="form-control"
                                    text="선택"
                                    :value="category_id"
                                    :options="CategoryOptions"
                                    @setValue="handleSetCategoryId"></select-box>

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
            </div>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="recruitList.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.company_name }}</td>
                    <td>{{ slotProps.row.applied_resumes_count }}</td>
                    <td>
                        <router-link :to="`/admin/user/user/${slotProps.row.user_id}/1`">
                            {{ slotProps.row.user_id }}
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="`/admin/user/user/${slotProps.row.user_id}/1`">{{ slotProps.row.user.name }}
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="`/admin/user/user/${slotProps.row.user_id}/1`">{{ slotProps.row.user.email }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.created_at }}</td>
                    <td>{{ slotProps.row.expired_at }}</td>
                    <td>{{ Helper.msToDate(Helper.dateCompareWithNow(slotProps.row.expired_at)) }}일</td>
                    <td>
                        <a :href="`/albatalk/recruit/${slotProps.row.id}`"
                           class="btn btn-info float-left mr-2">
                            보기
                        </a>
                    </td>
                    <td>
                        <button-open :isOpen="slotProps.row.is_open"
                                     class="btn-danger text-white border-danger float-left mr-2"
                                     @setStatus="handleSetStatus(slotProps.row.id)"></button-open>
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
    name: "AlbaTalkRecruit",
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
                    name: 'title',
                    text: '치과명',
                    width: '10%'
                },
                {
                    name: 'resumeCount',
                    text: '이력서',
                    width: '5%'
                },
                {
                    name: 'user_id',
                    text: '아이디',
                    width: '8%'
                },
                {
                    name: 'name',
                    text: '이름',
                    width: '8%'
                },
                {
                    name: 'email',
                    text: '이메일',
                    width: '14%'
                },
                {
                    name: 'created_at',
                    text: '등록일시',
                    width: '12%'
                },
                {
                    name: 'ended_at',
                    text: '마감일시',
                    width: '12%'
                },
                {
                    name: 'banner_date',
                    text: '배너게재기간',
                    width: '10%'
                },
                {
                    name: 'status',
                    text: '현황',
                    width: '8%'
                },
                {
                    name: 'public',
                    text: '노출',
                    width: '8%'
                },
            ]
        },
        CategoryOptions() {
            return [
                {
                    id: '0',
                    name: '진행중'
                },
                {
                    id: '1',
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
    }
}
</script>

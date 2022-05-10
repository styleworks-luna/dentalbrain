<template>
    <layout title="등록 정보">
        <template v-slot:button>
            <router-link to="/admin/certificate/create/certificate/"
                         class="btn btn-lg btn-info">
                자격증 생성
            </router-link>
            <router-link to="/admin/certificate/create/completion/"
                         class="btn btn-lg btn-info">
                수료증 생성
            </router-link>
        </template>
        <template v-slot:search>
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0" style="font-size: 12px">증명서 등록 정보 (자격증 {{  }}건 | 수료증 {{}}건) ]</p>
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
                        :data="certificationList.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.type }}</td>
                    <td>{{ slotProps.row.title }}</td>
                    <td>
                        <router-link :to="`certificate/${slotProps.row.id}`"
                           class="btn btn-info">
                            수정
                        </router-link>
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

import Certificate from '@/api/admin/certificate/Certificate.js'

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
                    width: '10%'
                },
                {
                    name: 'category',
                    text: '구분',
                    width: '10%'
                },
                {
                    name: 'title',
                    text: '제목',
                    width: '30%'
                },
                {
                    name: 'edit',
                    text: '수정',
                    width: '20%'
                }
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
            certificationList: {
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
                category: this.category_id
            }
            Certificate.getData(params).then(res => {
                this.certificationList.data = res.data;
            })
        },
        handleSetCategoryId(id) {
            this.category_id = id;
        },
    }
}
</script>

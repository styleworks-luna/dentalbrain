<template>
    <layout title="문의내역">
        <template v-slot:search>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <select-box class="form-control"
                                :value="gubun"
                                :options="gubunOptions"
                                @setValue="handleSetGubun"></select-box>

                    <div class="input-group">
                        <input class="form-control"
                               type="text"
                               placeholder="내용, 이름"
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
                        :data="inquires.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>
                        {{ slotProps.row.category_name }}
                    </td>
                    <td>
                        <router-link :to="`/admin/customer/inquire/${slotProps.row.id}/${page}`">
                            {{ slotProps.row.title }}
                        </router-link>
                    </td>
                    <td>{{ slotProps.row.name }}</td>
                    <td>{{ slotProps.row.created_at }}</td>
                    <td>
                        <template v-if="slotProps.row.is_answer == 1 ">완료</template>
                        <template v-else>미완료</template>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="inquires" @pagination-change-page="getData" class="mb-0">
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

// api
import Inquire from '@/api/admin/customer/Inquire.js';

export default {
    name: 'AdminInquire',
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen,
        'select-box': SelectBox
    },
    data() {
        return {
            inquires: {
                data: []
            },
            keyword: '',
            gubun: 'all',
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
                    width: '8%'
                },
                {
                    name: 'category',
                    text: '구분',
                    width: '8%'
                },
                {
                    name: 'title',
                    text: '제목',
                    width: '42%'
                },
                {
                    name: 'name',
                    text: '이름',
                    width: '12%'
                },
                {
                    name: 'created_at',
                    text: '작성일',
                    width: '20%'
                },
                {
                    name: 'is_answer',
                    text: '답변상태',
                    width: '10%'
                },
            ]
        },
        gubunOptions() {
            return [
                {
                    id: 'all',
                    name: '구분'
                },
                {
                    id: 'notCompleted',
                    name: '미완료'
                },
                {
                    id: 'Completed',
                    name: '완료'
                },
                {
                    id: 'normal',
                    name: '일반'
                },
                {
                    id: 'refund',
                    name: '환불'
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
                gubun: this.gubun,
                page: page
            };

            Inquire.getData(params).then(res => {
                this.inquires = res.data.inquiry;
                // 뒤로가기 page에 따라 reload
                const path = `/admin/customer/inquire/${page}`
                if (this.$route.path !== path) this.$router.push(path);
            }).catch(err => {
                this.inquires = [];
            });
        },
        handleSetGubun(gubun) {
            this.gubun = gubun;
        }
    }
}
</script>

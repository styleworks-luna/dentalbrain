<template>
    <layout title="오프라인 강의">
        <template v-slot:button>
            <router-link to="/admin/lecture/offline/create"
                         class="btn btn-lg btn-info">
                오프라인 강의 관리
            </router-link>
        </template>

        <template v-slot:search>
            <div class="float-right">
                <form @submit.prevent="getData">
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
                    <td>{{ slotProps.row.place.started_at }}</td>
                    <td>{{ slotProps.row.place.ended_at }}</td>
                    <td>
                        {{ slotProps.row.students_count }}명
                        <router-link :to="`/admin/lecture/offline/${slotProps.row.id}/student`"
                                     class="btn btn-info ml-4">
                            보기
                        </router-link>
                    </td>
                    <td>
                        <router-link :to="`/admin/lecture/offline/${slotProps.row.id}`"
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

//api
import Offline from '@/api/admin/lecture/Offline.js'

export default {
    name: 'AdminOffline',
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen
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
                    name: 'started_at',
                    text: '시작일시'
                },
                {
                    name: 'ended_at',
                    text: '종료일시'
                },
                {
                    name: 'count',
                    text: '수강현황'
                },
                {
                    name: 'control',
                    text: '수정'
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
                page: page,
                keyword: this.keyword
            };

            Offline.getData(params).then(res => {
                this.lectures = res.data.programs;
            }).catch(err => {
                this.lectures = [];
            });
        },
        handleSetStudent(id) {
            Offline.setStudent(id).then(res => {
                this.getData();
                alert(res.data.msg);
            })
        }
    }
}
</script>

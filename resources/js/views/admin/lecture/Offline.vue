<template>
    <layout title="온라인 강의">
        <template v-slot:button>
            <router-link to="/admin/lecture/offline/create"
                         class="btn btn-lg btn-info">
                오프라인 강의 관리
            </router-link>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="lectures.data">
                <template v-slot:list="slotProps">

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

export default {
    name: 'AdminOffline',
    components: {
        'table-grid': Table
    },
    data() {
        return {
            lectures: {
                data: []
            },
            page: 1
        }
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
                page: page
            };

            Faq.getData(params).then(res => {
                this.lectures = res.data.lecture;
            }).catch(err => {
                this.lectures = [];
            });
        },
    }
}
</script>

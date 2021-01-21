<template>
    <layout title="배너관리" >
        <template v-slot:button>
            <router-link to="/admin/banner/create"
                         class="btn btn-lg btn-info">
                 새로 만들기
            </router-link>
        </template>

        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="banners.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <template>
                        <td v-if=" slotProps.row.position == 0">상단배너</td>
                        <td v-if=" slotProps.row.position == 1">바배너</td>
                        <td v-if=" slotProps.row.position == 2">추천배너</td>
                        <td v-if=" slotProps.row.position == 3">하단배너</td>
                    </template>
                    <td>{{ slotProps.row.order }}</td>
                    <td>{{ slotProps.row.link }}</td>
                    <td>{{ slotProps.row.started_at }}{{ slotProps.row.ended_at }}</td>
                    <td>{{ slotProps.row.views }}</td>
                    <td class="overflow-hidden mr-auto ml-auto">
                        <router-link :to="`/admin/banner/${slotProps.row.id}`"
                                     class="btn btn-info float-left mr-3">
                            수정
                        </router-link>
                        <button-open  class="btn btn-warning float-left w-25"
                                        :isOpen="slotProps.row.is_open"
                                     @setStatus="handleSetStatus(slotProps.row.id)"></button-open>
                        <button class="btn btn-danger float-left ml-3" @click="destroy(slotProps.row.id)">삭제</button>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="banners" @pagination-change-page="getData" class="mb-0">
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

// api
import Banner from '@/api/admin/banner/Banner.js';

export default {
    name: 'AdminUser',
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen
    },
    data() {
        return {
            banners: {
                data: []
            },
            page: 1
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
                    name: 'position',
                    text: '종류'
                },
                {
                    name: 'order',
                    text: '중요도'
                },
                {
                    name: 'link',
                    text: '연결링크'
                },
                {
                    name: 'started_at',
                    text: '표시기간'
                },
                {
                    name: 'views',
                    text: '클릭회수'
                },
                {
                    name: 'commend',
                    text: '명령'
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

            Banner.getData(params).then(res => {
                console.log(res);
                this.banners = res.data.banners;
            }).catch(err => {
                this.banners = [];
            });
        },
        handleSetStatus(id) {
            Banner.setStatus(id).then(res => {
                this.getData();
                alert(res.data.msg);
            }).catch(err => {
                alert('오류');
            })
        },
        destroy(id) {
            Banner.destroy(id).then(res => {
                alert(res.data.msg);
            })
        },

    }
}
</script>

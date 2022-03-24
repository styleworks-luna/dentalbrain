<template>
    <layout title="배너관리 3" >
        <template v-slot:button>
            <router-link to="/admin/banner3/create"
                         class="btn btn-lg btn-info">
                새로 만들기
            </router-link>
        </template>

        <template v-slot:search>
            <div class="float-right">
                <form @submit.prevent="getData">
                    <date-picker class="mr-3" @setTime="handleSetDate"></date-picker>

                    <div class="input-group">
                        <input class="form-control"
                               type="text"
                               placeholder="제목 검색"
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
                        :data="banners2.data">
                <template v-slot:list="slotProps">
                    <td>{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.categories.name }}</td>
                    <td>{{ slotProps.row.order }}</td>
                    <td>{{ slotProps.row.title }}</td>
                    <td>{{ slotProps.row.program_id }}</td>
                    <td>
                        노출 시작 : {{ slotProps.row.started_at }} ~<br>
                        노출 종료 : {{ slotProps.row.ended_at }}
                    </td>
                    <td>{{ slotProps.row.views }}</td>
                    <td>
                        <router-link :to="`/admin/banner3/${slotProps.row.id}/${page}`"
                                     class="btn btn-info float-left mr-2">
                            수정
                        </router-link>
                        <button-open  class="btn btn-warning text-white border-warning float-left mr-2"
                                      :isOpen="slotProps.row.is_open"
                                      @setStatus="handleSetStatus(slotProps.row.id)"></button-open>
                        <button class="btn btn-danger float-left" @click="destroy(slotProps.row.id)">삭제</button>
                    </td>
                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="banners2" :limit=3 @pagination-change-page="getData" class="mb-0">
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
import DatePicker from '@/components/common/DatePicker.vue'

// api
import Banner3 from '@/api/admin/banner/Banner3.js';

// mixins
import { BannerCategoryMixin } from '@/mixins/admin/banner/Banner.js';

export default {
    name: 'AdminUser',
    mixins: [
        BannerCategoryMixin
    ],
    components: {
        'table-grid': Table,
        'button-open': ButtonOpen,
        'select-box': SelectBox,
        'date-picker': DatePicker
    },
    data() {
        return {
            banners2: {
                data: []
            },
            keyword: '',
            date: '',
            page: this.$route.params.page || 1,
        }
    },
    created() {
        this.category_id = '';
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
                    width: '6%'
                },
                {
                    name: 'category_id',
                    text: '종류',
                    width: '10%'
                },
                {
                    name: 'order',
                    text: '중요도',
                    width: '8%'
                },
                {
                    name: 'order',
                    text: '제목',
                    width: '20%'
                },
                {
                    name: 'program_id',
                    text: '강의번호',
                    width: '7%'
                },
                {
                    name: 'started_at',
                    text: '표시기간',
                    width: '25%'
                },
                {
                    name: 'views',
                    text: '클릭회수',
                    width: '9%'
                },
                {
                    name: 'commend',
                    text: '명령',
                    width: '22%'
                }
            ]
        },
    },
    methods: {
        getData(page = this.page) {
            if (this.Helper.nullCheck(page)) {
                page = 1;
            }
            this.page = page;

            let params = {
                keyword: this.keyword,
                category_id: 6,
                date: this.Helper.dateFormatYDM(this.date),
                page: page
            };

            Banner3.getData(params).then(res => {
                this.banners2 = res.data.banners;
                // 뒤로가기 page에 따라 reload
                const path = `/admin/banner3/${page}`
                if (this.$route.path !== path) this.$router.push(path);
            }).catch(err => {
                this.banners2 = [];
            });
        },
        handleSetStatus(id) {
            Banner3.setStatus(id).then(res => {
                this.getData();
                alert(res.data.msg);
            })
        },
        handleSetDate(date) {
            this.date = date;
        },
        destroy(id) {
            Banner3.destroy(id).then(res => {
                alert(res.data.msg);
            })
        }
    }
}
</script>

<template>
    <layout title="타이틀 관리">
        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="titles">
                <template v-slot:list="slotProps">
                    <td>구역{{ slotProps.row.id }}</td>
                    <td>{{ slotProps.row.title }}</td>
                    <td><input type="text" class="form-control" placeholder="20자 이하로 입력해주세요."
                               v-model="inputText[slotProps.row.id]"></td>
                    <td>
                        <button type="submit" class="btn btn-info" @click="update(slotProps.row.id,inputText[slotProps.row.id])">저장</button>
                    </td>
                </template>
            </table-grid>
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
import Title from '@/api/admin/banner/Title.js';

// mixins
import {BannerCategoryMixin} from '@/mixins/admin/banner/Banner.js';

export default {
    name: 'AdminTitle',
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
            titles: [],
            inputText: [],
            id: '',
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
                    text: '구분',
                    width: '6%'
                },
                {
                    name: 'title',
                    text: '현재 타이틀',
                    width: '10%'
                },
                {
                    name: 'order',
                    text: '변경할 타이틀',
                    width: '15%'
                },
                {
                    name: 'commend',
                    text: '기능',
                    width: '10%'
                },
            ]
        },
    },
    methods: {
        getData() {
            Title.getData().then(res => {
                this.titles = res.data.banner_titles;
            })
        },
        update(id, title) {
            let data = {
                title: title
            };
            Title.update(id, data).then(res => {
                alert("변경되었습니다.");
            })
        }
    }

}
</script>

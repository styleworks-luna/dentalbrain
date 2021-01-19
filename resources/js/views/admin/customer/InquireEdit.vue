<template>
    <layout title="FAQ 수정">
        <template v-slot:body>


            <single-group  name="번호" :size="9" :isRow="true">
                <template v-slot:content>
                    {{ id }}
                </template>
            </single-group>

            <single-group  name="작성일" :size="9" :isRow="true">
                <template v-slot:content>
                    {{ data.created_at }}
                </template>
            </single-group>

            <single-group  name="이메일" :size="9" :isRow="true">
                <template v-slot:content>
                    {{ data.email }}
                </template>
            </single-group>

            <single-group  name="이름" :size="9" :isRow="true">
            <template v-slot:content>
                    {{ data.name }}
            </template>
            </single-group>

            <single-group  name="연락처" :size="9" :isRow="true">
                <template v-slot:content>
                    {{ data.phone }}
                </template>
            </single-group>

            <single-group  name="문의내용" :size="9" :isRow="true">
                <template v-slot:content>
                    {{ data.content }}
                </template>
            </single-group>

            <single-group  name="구분" :size="9" :isRow="true">
                <template v-slot:content>
                    <select-box class="form-control"
                                :value="category"></select-box>
                </template>
            </single-group>

        </template>

        <template v-slot:footer>
            <div class="float-left">
                <button type="button" class="btn btn-danger"
                        @click="destroy">삭제
                </button>
            </div>

            <div class="float-right">
                <button type="submit" class="btn btn-info"
                        @click="update">저장
                </button>
                <router-link to="/admin/customer/inquire"
                             class="btn btn-dark">목록
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// api
import Inquire from '@/api/admin/customer/Inquire.js';

// mixins
import {InquireMixin} from '@/mixins/admin/customer/Inquire.js';

export default {
    name: 'AdminInquireEdit',
    mixins: [
        InquireMixin
    ],
    data() {
        return {
            id: '',
            data: []
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
                    name: 'created_at',
                    text: '작성일'
                },
                {
                    name: 'email',
                    text: '이메일'
                },
                {
                    name: 'name',
                    text: '이름'
                },
                {
                    name: 'phone',
                    text: '연락처'
                },
            ]
        }
    },
    created() {
        this.id = this.$route.params.id;
    },
    mounted() {
        this.getEditData();
    },
    methods: {
        getEditData() {

            Inquire.getEditData(this.id).then(res => {
                const result = res.data.inquiry;

                this.data = result;
            });

        },
        update() {
            let data = {
                category: this.category,
            };

            Inquire.update(this.id, data).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/customer/inquire');
            }).catch(err => {
                alert('오류');
            });
        },
        destroy() {
            Inquire.destroy(this.id).then(res => {
                alert(res.data.msg);
                this.$router.push('/admin/customer/inquire');
            })
        }
    }
}
</script>

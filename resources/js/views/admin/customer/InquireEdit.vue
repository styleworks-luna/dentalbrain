<template>
    <layout title="FAQ 수정">
        <template v-slot:body>
<!--            <single-group> {{ this.email }}</single-group>
            <single-group> {{ this.name }}</single-group>
            <single-group> {{ this.phone }}</single-group>-->
            <single-group name="구분"
                          :isRow="true"
                          :isRequired="true"
                          :size="6">
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
            data: {}
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
                console.log(res);
            });
        },
        update() {
            let data = {
                question: this.question,
                answer: this.answer,
                category_id: this.category_id,
                is_open: this.is_open
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

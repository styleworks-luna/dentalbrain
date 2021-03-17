<template>
    <layout title="이메일 보내기" class="email">
        <template v-slot:body>
            <section class="send-area">
                <div class="title-area overflow-hidden">
                    <h4>발송 대상 선택</h4>
                    <p>이메일 발송을 원하는 대상을 선택하여 오른쪽 영역에 추가해주세요.</p>
                </div>

                <div class="select-wrap waiting-wrap">
                    <div class="select-list">
                        <ul class="user-list">
                            <li v-for="(student,index) in students">
                                <label>
                                    <input type="checkbox" :id="`user${index}`" v-model="checks[index]">
                                    <span class="name">{{ student.user.name }}</span>
                                    <span class="email">{{ student.email }}</span>
                                    <span class="phone">{{ student.phone }}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="manage-area">
                        <a href="" @click.prevent="selectAll">전체선택</a>
                        <a href="">전체해제</a>
                        <div class="count">
                            <span class="total-count">명</span>
                        </div>
                    </div>
                </div>

                <div class="button">
                    <a href="">이동 ▶</a>
                    <a href="">전체이동 ▶</a>
                </div>

                <div class="select-wrap selected-wrap">

                </div>

            </section>

        </template>
    </layout>
</template>

<script>
// component
import Table from '@/components/admin/grid/Table.vue';

// api
import Email from '@/api/admin/email/Email.js'

export default {
    name: 'AdminEmail',
    components: {
        'table-grid': Table,
    },
    data() {
        return {
            id: '',
            students: [],
            checks:[],
        }
    },
    created() {
        this.id = this.$route.params.id;
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            Email.getData(this.id).then(res => {
                this.students = res.data.students;
            })
        },
        selectAll() {
        }
    }
}
</script>

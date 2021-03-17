<template>
    <layout title="이메일 보내기" class="email">
        <template v-slot:body>
            <section class="send-area">
                <div class="title-area overflow-hidden">
                    <h4>발송 대상 선택</h4>
                    <p>이메일 발송을 원하는 대상을 선택하여 오른쪽 영역에 추가해주세요.</p>
                </div>

                <div class="select-wrap">
                    <div class="input-wrap">
                        <input type="text">
                        <input type="text">
                        <a href="">추가</a>
                    </div>

                    <div class="select-list">
                        <ul class="user-list">
                            <li v-for="student in students">
                                <label>
                                    <input type="checkbox" @click="countNumber">
                                    <span class="name">{{ student.user.name }}</span>
                                    <span class="email">{{ student.email }}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="manage-area">
                        <a href="" @click.prevent="selectAll">전체선택</a>
                        <a href="" @click.prevent="releaseAll">전체해제</a>
                        <div class="count">
                            <span class="total-count">{{ count }}명</span>
                        </div>
                    </div>
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
            count: 0,
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
        selectAll(event) {
            let parent = event.target.closest('.select-wrap');
            let checkboxs = parent.querySelectorAll('.user-list li input[type="checkbox"]');

            checkboxs.forEach(checkbox => {
                checkbox.checked = true;
            });
            this.count = checkboxs.length;
        },
        releaseAll(event) {
            let parent = event.target.closest('.select-wrap');
            let checkboxs = parent.querySelectorAll('.user-list li input[type="checkbox"]');

            checkboxs.forEach(checkbox => {
                checkbox.checked = false;
            });

            this.count = 0;
        },
        countNumber(event) {
            if(event.target.checked == true) {
                this.count++;
            } else {
                this.count--;
            }
        }
    }
}
</script>

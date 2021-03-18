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
                        <input type="text" id="name">
                        <input type="text" id="email">
                        <a href="" @click.prevent="add">추가</a>
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

            <section class="write-area">
                <div class="title-area overflow-hidden">
                    <h4>발송 내용</h4>
                    <p>발송할 이메일 내용을 적어주세요.</p>
                </div>
                <editor :content="content" @setEditor="handleSetEditor"></editor>
            </section>

            <section class="btn-zone">
                <button>전송</button>
            </section>

        </template>
    </layout>
</template>

<script>
// component
import Table from '@/components/admin/grid/Table.vue';
import Editor from '@/components/admin/form/Editor.vue';

// api
import Email from '@/api/admin/email/Email.js'

export default {
    name: 'AdminEmail',
    components: {
        'table-grid': Table,
        Editor,
    },
    data() {
        return {
            id: '',
            students: [],
            count: 0,
            content: ''
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
        },
        add() {
            let inputName = document.getElementById('name').value;
            let inputEmail = document.getElementById('email').value;
            let regExpEmail = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/

            if(regExpEmail.test(inputEmail) == false) {
                alert('이메일 형식이 올바르지 않습니다.')
                return false;
            }

            this.students.push({
                user : {
                    name: inputName
                },
                email : inputEmail
            });

            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
        },
        handleSetEditor(data) {
            this.content = data;
        },
    }
}
</script>

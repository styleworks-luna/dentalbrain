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
                        <input type="text" id="name" class="form-control w-25 float-left" placeholder="이름 입력">
                        <input type="text" id="email" class="form-control w-40 float-left" placeholder="이메일 입력">
                        <a href="" class="btn btn-secondary" @click.prevent="add">추가</a>
                    </div>

                    <div class="select-list">
                        <ul class="user-list">
                            <li v-for="student in students">
                                <label>
                                    <input type="checkbox" @click="(event) => checkStudent(event, student.user.email)">
                                    <span class="name">{{ student.name }},</span>
                                    <span class="email">{{ student.email }}</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="manage-area">
                        <a href="" class="btn btn-secondary" @click.prevent="selectAll">전체선택</a>
                        <a href="" class="btn btn-dark" @click.prevent="releaseAll">전체해제</a>
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

                <div class="input-wrap overflow-hidden">
                    <label for="title" class="float-left">제목 :</label>
                    <input type="text" id="title" class="form-control w-75 float-left" placeholder="제목 입력"
                           v-model="title">
                </div>

                <div class="editor-wrap">
                    <editor :content="content" @setEditor="handleSetEditor"></editor>
                </div>
            </section>

            <section class="btn-zone">
                <button type="submit" id="btn-send" class="btn btn-primary" @click="sendEmail">전송</button>
            </section>

            <div class="loading-pop" v-if="showModal">
                <h1>이메일 전송중</h1>
            </div>

            <div class="dim" v-if="showModal"></div>

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
            content: '',
            title: '',
            email: [],
            showModal: false,
            sort: '',
            keyword: '',
            job_name_id: '',
            member: '',
            page: '',
        }
    },
    created() {
        this.id = this.$route.params.id;
        this.sort = this.$route.params.sort;
        if (this.sort == 'user') {
            this.keyword = this.$route.query.keyword;
            this.job_name_id = this.$route.query.job_name_id;
            this.member = this.$route.query.member;
            this.page = this.$route.query.page;
        }
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            if (this.sort == 'program') {
                Email.getData(this.id).then(res => {
                    this.students = res.data;
                })
            } else if (this.sort == 'user') {
                let params = {
                    page: this.page,
                    keyword: this.keyword,
                    job_name_id: this.job_name_id,
                    member: this.member,
                };
                Email.getUserData(params).then(res => {
                    this.students = res.data;
                }).catch(err => {
                    this.students = [];
                });
            }
        },
        checkStudent(event, data) {
            if (event.target.checked == true) {
                this.count++;
                this.email.push(data);
            } else {
                this.count--;
                const index = this.email.indexOf(data);
                this.email.splice(index, 1);
            }
        },
        selectAll(event) {
            let parent = event.target.closest('.select-wrap');
            let checkboxs = parent.querySelectorAll('.user-list li input[type="checkbox"]');

            checkboxs.forEach(checkbox => {
                checkbox.checked = true;
            });

            this.email = [];

            this.students.forEach(student => {
                this.email.push(student.email)
            });

            this.count = checkboxs.length;
        },
        releaseAll(event) {
            let parent = event.target.closest('.select-wrap');
            let checkboxs = parent.querySelectorAll('.user-list li input[type="checkbox"]');

            checkboxs.forEach(checkbox => {
                checkbox.checked = false;
            });

            this.email = [];

            this.count = 0;
        },
        add() {
            let inputName = document.getElementById('name').value;
            let inputEmail = document.getElementById('email').value;
            let regExpEmail = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/

            if (regExpEmail.test(inputEmail) == false) {
                alert('이메일 형식이 올바르지 않습니다.')
                return false;
            }

            this.students.push({
                user: {
                    name: inputName,
                    email: inputEmail
                },
            });

            document.getElementById('name').value = '';
            document.getElementById('email').value = '';
        },
        handleSetEditor(data) {
            this.content = data;
        },
        sendEmail() {
            this.showModal = true;

            document.getElementById('btn-send').style.pointerEvents = 'none';

            let data = {
                program_id: this.id,
                email: this.email,
                message: this.content,
                title: this.title,
            }

            Email.update(data).then(res => {
                this.showModal = false;
                alert(res.data.msg);
                window.location.reload();
            }).catch(err => {
                this.showModal = false;
                document.getElementById('btn-send').style.pointerEvents = 'auto';
            });
        }
    }
}
</script>

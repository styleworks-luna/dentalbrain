<template>
    <layout title="문자 보내기" class="sms">
        <template v-slot:body>
            <section class="send-area">
                <div class="title-area overflow-hidden">
                    <h4>발송 대상 선택</h4>
                    <p>문자 발송을 원하는 대상을 선택하여 오른쪽 영역에 추가해주세요.</p>
                </div>

                <div class="select-wrap">
                    <div class="input-wrap">
                        <input type="text" id="name" class="form-control w-25 float-left" placeholder="이름 입력">
                        <input type="text" id="phone" class="form-control w-40 float-left" placeholder="휴대전화 입력">
                        <a href="" class="btn btn-secondary" @click.prevent="add">추가</a>
                    </div>

                    <div class="select-list">
                        <ul class="user-list">
                            <li v-for="student in students">
                                <label>
                                    <input type="checkbox" @click="(event) => checkStudent(event, student.phone)">
                                    <span class="name">{{ student.user.name }},</span>
                                    <span class="phone">{{ student.phone }}</span>
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
                    <p>발송할 문자 내용을 적어주세요.</p>
                </div>

                <div class="editor-wrap">
                    <textarea name="" id=""></textarea>
                </div>
            </section>

            <section class="btn-zone">
                <button type="submit" id="btn-send" class="btn btn-primary" @click="sendSms">전송</button>
            </section>

            <div class="loading-pop" v-if="showModal">
                <h1>문자 전송중</h1>
            </div>

            <div class="dim" v-if="showModal"></div>

        </template>
    </layout>
</template>

<script>
// component
import Table from '@/components/admin/grid/Table.vue';

// api
import SMS from '@/api/admin/email/Sns.js'

export default {
    name: 'AdminSms',
    components: {
        'table-grid': Table,
    },
    data() {
        return {
            id: '',
            students: [],
            count: 0,
            content: '',
            phone: [],
            showModal: false,
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
            SMS.getData(this.id).then(res => {
                this.students = res.data.students;
            })
        },
        checkStudent(event, data) {
            if (event.target.checked == true) {
                this.count++;
                this.phone.push(data);
            } else {
                this.count--;
                const index = this.phone.indexOf(data);
                this.phone.splice(index, 1);
            }
        },
        selectAll(event) {
            let parent = event.target.closest('.select-wrap');
            let checkboxs = parent.querySelectorAll('.user-list li input[type="checkbox"]');

            checkboxs.forEach(checkbox => {
                checkbox.checked = true;
            });

            this.phone = [];

            this.students.forEach(student => {
                this.phone.push(student.phone)
            });

            this.count = checkboxs.length;
        },
        releaseAll(event) {
            let parent = event.target.closest('.select-wrap');
            let checkboxs = parent.querySelectorAll('.user-list li input[type="checkbox"]');

            checkboxs.forEach(checkbox => {
                checkbox.checked = false;
            });

            this.phone = [];

            this.count = 0;
        },
        add() {
            let inputName = document.getElementById('name').value;
            let inputPhone = document.getElementById('phone').value;
            let regExpPhone = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/

            if (regExpPhone.test(inputPhone) == false) {
                alert('이메일 형식이 올바르지 않습니다.')
                return false;
            }

            this.students.push({
                user: {
                    name: inputName
                },
                phone: inputPhone
            });

            document.getElementById('name').value = '';
            document.getElementById('phone').value = '';
        },
        handleSetEditor(data) {
            this.content = data;
        },
        sendSms() {
            this.showModal = true;

            document.getElementById('btn-send').style.pointerEvents = 'none';

            let data = {
                phone: this.phone,
                message: this.content,
            }

            SMS.update(data).then(res => {
                this.showModal = false;
                alert(res.data.msg);
                this.$router.push('/admin/lecture/online');
            }).catch(err => {
                this.showModal = false;
                document.getElementById('btn-send').style.pointerEvents = 'auto';
            });
        }
    }
}
</script>

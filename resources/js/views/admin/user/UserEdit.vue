<template>
    <layout title="회원정보 상세" class="user">
        <template v-slot:body>
            <!-- 아이디 -->
            <single-group name="아이디"
                          :isRow="true"
                          :isRequired="true"
                          :size="3">
                <template v-slot:content>
                    {{login_id}}
                </template>
            </single-group>

            <!-- 이름 -->
            <single-group name="이름"
                          :isRow="true"
                          :isRequired="true" :size="2.5">
                <template v-slot:content>
                    <input class="form-control" placeholder="이름을 입력해 주세요."
                           v-model="name"/>
                </template>
            </single-group>

            <!-- 이메일 -->
            <single-group name="이메일"
                          :isRow="true"
                          :isRequired="true" :size="2.5">
                <template v-slot:content>
                    <input class="form-control" placeholder="이메일을 입력해 주세요."
                           v-model="email"/>
                </template>
            </single-group>

            <!-- 전화번호 -->
            <single-group name="전화번호"
                          :isRow="true"
                          :isRequired="true" :size="2.5">
                <template v-slot:content>
                    <input class="form-control" placeholder="전화번호를 입력해 주세요."
                           v-model="phone"/>
                </template>
            </single-group>

            <!-- 비밀번호 -->
            <single-group name="비밀번호"
                          :isRow="true"
                          :isRequired="true" :size="2.5">
                <template v-slot:content>
                    <button class="btn btn-info" @click="findPassword">변경하기</button>
                </template>
            </single-group>


            <!-- 직업군 -->
            <single-group name="직업군"
                          :isRow="true"
                          :isRequired="true"
                          :size="4">
                <template v-slot:content>
                    <div class="select-box-wrap float-left">
                        <select-box class="form-control"
                                    :value="job_name_id"
                                    :options="jobOptions"
                                    @setValue="handleSetJobyId"
                        ></select-box>
                    </div>

                    <div class="input-wrap float-left">
                        <input type="text" class="form-control ml-3" placeholder="면허번호를 입력해 주세요."
                               v-model="license_num">
                    </div>

                </template>
            </single-group>

            <!-- 이메일 수신 -->
            <single-group name="이메일 수신"
                          :isRow="true"
                          :size="2.5">
                <template v-slot:content>
                    <input type="checkbox" name="email-check" id="email-check" v-model="allow_email">
                    <label for="email-check">수신동의 선택</label>
                </template>
            </single-group>

            <!-- 유료회원 여부 -->
            <single-group name="유료회원 여부"
                          :isRow="true"
                          :size="2.5">
                <template v-slot:content>
                    <div class="input-wrap">
                        <input type="checkbox" name="paid-check" id="paid-check" v-model="has_membership" @change="handleCheckbox">
                        <label for="paid-check">유료회원 선택</label>
                    </div>
                    <div class="date-wrap">
                        <date-picker class="mr-3"
                                     :time="membership_started_date"
                                     :disabled="disabled"
                                     @setTime="handleSetStartDate"></date-picker>
                        <time-picker class="mr-3"
                                     :time="membership_started_time"
                                     :disabled="disabled"
                                     @setTime="handleSetStartTime"></time-picker>

                        <p class="float-left mr-3 mt-2">부터</p>

                        <date-picker class="mr-3"
                                     :time="membership_ended_date"
                                     :disabled="disabled"
                                     @setTime="handleSetEndDate"></date-picker>
                        <time-picker :time="membership_ended_time"
                                     :disabled="disabled"
                                     @setTime="handleSetEndTime"></time-picker>
                    </div>
                </template>
            </single-group>

        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info"
                        @click="update">저장
                </button>
                <router-link :to="`/admin/user/${page}`"
                             class="btn btn-dark">취소
                </router-link>
            </div>
        </template>
    </layout>
</template>

<script>
//api
import User from '@/api/admin/user/User.js';

//Mixin
import {UserMixin} from '@/mixins/admin/user/User.js'

export default {
    name: 'AdminUserEdit',
    mixins: [
        UserMixin,
    ],
    data() {
        return {
            id: '',
            data: {},
            page: this.$route.params.page,
            disabled: true,
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
            User.getEditData(this.id).then(res => {
                const result = res.data[0].user;

                this.login_id = result.login_id;
                this.name = result.name;
                this.email = result.email;
                this.phone = result.phone;
                this.job_name_id = result.job_name_id;
                this.license_num = result.license_num;
                this.allow_email = result.allow_email;
                this.is_paid = result.is_paid;

                this.has_membership = result.has_membership;

                if(result.has_membership) {
                    this.membership_started_date = this.Helper.dateFullFormat(res.data[0].membership_expired_at);
                    this.membership_started_time = this.Helper.timeFormat(this.membership_started_date);
                    this.membership_ended_date = this.Helper.dateFullFormat(res.data[0].membership_started_at);
                    this.membership_ended_time = this.Helper.timeFormat(this.membership_ended_date);
                    this.disabled = false;
                }
            });
        },
        update() {
            const membership_started_at = `${this.Helper.dateFormatYDM(this.membership_started_date)} ${this.membership_started_time}`;
            const membership_expired_at = `${this.Helper.dateFormatYDM(this.membership_ended_date)} ${this.membership_ended_time}`;

            let data = {
                login_id: this.login_id,
                name: this.name,
                email: this.email,
                phone: this.phone,
                job_name_id: this.job_name_id,
                license_num: this.license_num,
                allow_email: this.allow_email,
                is_paid: this.is_paid,
                has_membership: this.has_membership,
                membership_started_at: membership_started_at,
                membership_expired_at: membership_expired_at,
            };

            User.update(this.id, data).then(res => {
                alert(res.data.msg);
                window.history.back();
            })
        },
        findPassword(e) {
            e.target.disabled = true;

            User.findPassword(this.id).then(res => {
                e.target.disabled = false;
                alert(res.data.message);
            })
        },
        handleCheckbox() {
            var check = document.getElementById('paid-check').checked;

            if(!check) {
                this.disabled = true;
            } else {
                this.disabled = false;
            }
        },
    }
}
</script>

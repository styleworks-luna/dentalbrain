<template>
    <layout title="유료회원정보 상세" class="user-membership">
        <template v-slot:body>
            <single-group name="아이디"
                          :isRow="true"
                          :size="3">
                <template v-slot:content>
                    {{ login_id }}
                </template>
            </single-group>

            <single-group name="이름"
                          :isRow="true"
                          :size="3">
                <template v-slot:content>
                    {{ name }}
                </template>
            </single-group>

            <single-group name="이메일"
                          :isRow="true"
                          :size="3">
                <template v-slot:content>
                    {{ email }}
                </template>
            </single-group>

            <single-group name="전화번호"
                          :isRow="true"
                          :size="3">
                <template v-slot:content>
                    {{ phone }}
                </template>
            </single-group>

            <single-group name="직업군"
                          :isRow="true"
                          :size="4">
                <template v-slot:content>
                    <div class="select-box-wrap float-left">
                        {{ jobName }}
                    </div>

                    <div class="input-wrap float-left" v-if="license_num">
                        면허번호 : {{ license_num }}
                    </div>

                </template>
            </single-group>

            <div class="membership-content">
                <table>
                    <tr>
                        <th>날짜</th>
                        <th>추가</th>
                        <th>결제상태</th>
                        <th>결재방식</th>
                        <th>상태</th>
                    </tr>
                    <tr>
                        <td>
                        <div class="date-wrap float-left">
                            <date-picker class="mr-3"
                                         :time="membership_started_date"
                                         @setTime="handleSetStartDate"></date-picker>
                            <time-picker class="mr-3"
                                         :time="membership_started_time"
                                         @setTime="handleSetStartTime"></time-picker>

                            <p class="float-left mr-3 mt-2">부터</p>

                            <date-picker class="mr-3"
                                         :time="membership_ended_date"
                                         @setTime="handleSetEndDate"></date-picker>
                            <time-picker :time="membership_ended_time"
                                         @setTime="handleSetEndTime"></time-picker>
                        </div>
                        </td>
                        <td>
                            <button class="btn btn-ghost-dark d-block" @click="addMembership">추가</button>
                        </td>
                        <td><div class=""></div></td>
                        <td></td>
                    </tr>
                </table>
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
    name: "UserMembershipEdit",
    mixins: [
        UserMixin,
    ],
    data() {
        return {
            id: '',
            data: {},
            page: this.$route.params.page,
            // disabled: true,
        }
    },
    created() {
        this.id = this.$route.params.id;
    },
    mounted() {
        this.getEditData();
    },
    computed: {
        jobName() {
            switch (this.job_name_id) {
                case 1:
                    return '치과의사';
                case 2:
                    return '치과위생사';
                case 3:
                    return '치과조무사';
                case 4:
                    return '코디네이터';
                case 5:
                    return '학생';
                case 6:
                    return '기타';
            }
        },
    },
    methods: {
        getEditData() {
            User.getEditData(this.id).then(res => {
                console.log(res);
                const result = res.data[0].user;

                this.login_id = result.login_id;
                this.name = result.name;
                this.email = result.email;
                this.phone = result.phone;
                this.job_name_id = result.job_name_id;
                this.license_num = result.license_num;
                this.is_paid = result.is_paid;

                this.has_membership = result.has_membership;

                if (res.data[0].membership_started_at != null && res.data[0].membership_expired_at != null) {
                    this.membership_started_date = this.Helper.dateFullFormat(res.data[0].membership_started_at);
                    this.membership_started_time = this.Helper.timeFormat(this.membership_started_date);
                    this.membership_ended_date = this.Helper.dateFullFormat(res.data[0].membership_expired_at);
                    this.membership_ended_time = this.Helper.timeFormat(this.membership_ended_date);
                    // this.disabled = false;
                }
            });
        },
        addMembership() {

        }
    }
};
</script>

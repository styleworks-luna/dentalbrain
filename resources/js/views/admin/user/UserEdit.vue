<template>
    <layout title="FAQ 수정">
        <template v-slot:body>
            <!-- 제목 -->
            <single-group name="아이디"
                          :isRow="true"
                          :isRequired="true"
                          :size="3">
                <template v-slot:content>
                    {{ data.login_id }}
                </template>
            </single-group>

            <!-- 세부내용 -->
            <single-group name="이름"
                          :isRow="true"
                          :isRequired="true" :size="2.5">
                <template v-slot:content>
                    <input class="form-control" placeholder="이름을 입력해 주세요."
                              v-model="name" />
                </template>
            </single-group>

            <!-- 세부내용 -->
            <single-group name="이메일"
                          :isRow="true"
                          :isRequired="true" :size="2.5">
                <template v-slot:content>
                    <input class="form-control" placeholder="이메일을 입력해 주세요."
                              v-model="email"/>
                </template>
            </single-group>

            <!-- 세부내용 -->
            <single-group name="전화번호"
                          :isRow="true"
                          :isRequired="true" :size="2.5">
                <template v-slot:content>
                    <input class="form-control" placeholder="전화번호를 입력해 주세요."
                              v-model="phone"/>
                </template>
            </single-group>

            <!-- 세부내용 -->
            <single-group name="비밀번호"
                          :isRow="true"
                          :isRequired="true" :size="2.5">
                <template v-slot:content>
                    <button class="btn btn-info">변경하기</button>
                </template>
            </single-group>


            <!-- 카테고리 타입 -->
            <single-group name="직업군"
                          :isRow="true"
                          :isRequired="true"
                          :size="4">
                <template v-slot:content>
                    <div class="select-box-wrap float-left">
                        <select-box class="form-control"
                                    ></select-box>
                    </div>

                    <div class="input-wrap float-left">
                        <input type="text" class="form-control" placeholder="면허번호를 입력해 주세요.">
                    </div>

                </template>
            </single-group>

            <!-- 카테고리 타입 -->
            <single-group name="이메일 수신"
                          :isRow="true"
                          :size="2.5">
                <template v-slot:content>
                    <input type="checkbox" name="email-check" id="email-check">
                    <label for="email-check">수신동의 선택</label>
                </template>
            </single-group>

        </template>

        <template v-slot:footer>
            <div class="float-right">
                <button type="submit" class="btn btn-info"
                        @click="">저장</button>
                <router-link to="/admin/user"
                             class="btn btn-dark">취소</router-link>
            </div>
        </template>
    </layout>
</template>

<script>
// api
// import User from '@/api/admin/user/user.js';

//Mixin
import { UserMixin } from '@/mixins/admin/user/User.js'

export default {
    name: 'AdminuserEdit',
    mixins: [
        UserMixin,
    ],
    data() {
        return {
            id: '',
            data: {}
        }
    },
    created() {

    },
    mounted() {

    },
    methods: {

    }
}
</script>

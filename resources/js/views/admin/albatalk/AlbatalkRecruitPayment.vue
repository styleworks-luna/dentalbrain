<template>
    <layout title="구인등록 결제 금액">
        <template v-slot:body>
            <div class="input-group w-50 mb-5">
                <div class="input-group-prepend">
                    <label for="price" class="input-group-text">일반회원가</label>
                </div>
                <input class="form-control"
                       type="text"
                       id="price"
                       placeholder="일반 회원가 입력"
                       v-model="price">
                <span class="input-group-append">
                    <button class="btn btn-primary" type="submit" @click.prevent="changePrice">적용</button>
                </span>
            </div>
            <div class="input-group w-50 mb-5">
                <div class="input-group-prepend">
                    <label for="membership_price" class="input-group-text">유료회원가</label>
                </div>
                <input class="form-control"
                       type="text"
                       id="membership_price"
                       placeholder="유료 회원가 입력"
                       v-model="membership_price">
                <span class="input-group-append">
                    <button class="btn btn-primary" type="submit" @click.prevent="changeMembershipPrice">수정</button>
                </span>
            </div>
        </template>
    </layout>
</template>

<script>
export default {
    name: "AlbaTalkRecruitPayment",
    data() {
        return {
            price: "",
            membership_price: "",
        }
    },
    methods: {
        changePrice() {

        },
        changeMembershipPrice() {

        }
    }
}
</script>

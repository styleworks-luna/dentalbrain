<template>
    <div class="pop-up">

        <h1>환불 확인</h1>
        <div class="form-wrap">
            <template v-if="method == '가상계좌'">
                <div class="input-wrap">
                    <label :for="'accountNumber'  + programId">계좌번호</label>
                    <input type="text" id="accountNumber" placeholder="계좌번호를 입력해주세요." v-model="accountNumber"/>
                </div>
                <div class="input-wrap">
                    <label :for="'bank' + programId" class="select-label">은행</label>
                    <select name="payment-method" :id="'bank' + programId" class="select-menu" v-model="bank">
                        <option value="농협">NH농협은행</option>
                        <option value="국민">KB국민은행</option>
                        <option value="우리">우리은행</option>
                        <option value="신한">신한은행</option>
                        <option value="기업">IBK기업은행</option>
                        <option value="하나">하나은행</option>
                        <option value="경남">경남은행</option>
                        <option value="대구">대구은행</option>
                        <option value="부산">부산은행</option>
                        <option value="수협">Sh수협은행</option>
                        <option value="우체국">우체국예금보험</option>
                    </select>
                </div>
                <div class="input-wrap">
                    <label :for="'holderName' + programId">예금주</label>
                    <input type="text" :id="'holderName' + programId" placeholder="예금주를 입력해주세요." v-model="holderName"/>
                </div>
            </template>
            <div class="input-wrap">
                <label :for="'reason' + programId">환불이유</label>
                <input type="text" :id="'reason' + programId" placeholder="환불 이유를 입력해주세요." v-model="reason"/>
            </div>
        </div>
        <div class="btn-wrap">
            <button @click="destroy">확인</button>
            <button @click="$emit('close')">취소</button>
        </div>
    </div>
</template>

<script>
import Mypage from "@/api/mypage/Mypage.js"

export default {
    name: 'PopUp',
    props: {
        'methodTo': String,
        'programIdTo': Number,
    },
    data() {
        return {
            programId: '',
            method: '',
            accountNumber: '',
            holderName: '',
            bank: '',
            reason: '',
        }
    },
    mounted() {
        this.method = this.methodTo;
        this.programId = this.programIdTo;
        $(function() {
            // select menu
            var select_menu = $('.select-menu');

            if (select_menu.length > 0) {
                select_menu.selectmenu();
            }
        });
    },
    watch: {
        methodTo() {
            this.method = this.methodTo;
        },
        programIdTo() {
            this.programId = this.programIdTo;
        },
    },
    methods: {
        destroy() {
            let data = {}
            if (this.method == '가상계좌') {
                data = {
                    accountNumber: this.accountNumber,
                    holderName: this.holderName,
                    bank: this.bank,
                    reason: this.reason,
                };
            } else {
                data = {
                    reason: this.reason,
                };
            }

            Mypage.destroy(this.programId, data).then(res => {
                alert(res.data.msg);
                this.$emit('close');
                window.location.reload()
            }).catch(err => {
                alert(err);
            });
        }
    }
}
</script>

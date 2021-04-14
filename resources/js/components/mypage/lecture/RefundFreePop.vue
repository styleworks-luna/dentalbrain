<template>
    <div class="pop-up">
        <h1>취소 확인</h1>
        <div class="form-wrap">
            <div class="input-wrap">
                <label :for="'reason' + programId">취소이유</label>
                <input type="text" :id="'reason' + programId" placeholder="환불 이유를 입력해주세요." v-model="reason"/>
            </div>
        </div>
        <div class="btn-wrap">
            <button id="refund_confirm" @click="destroy">확인</button>
            <button @click="$emit('close')">취소</button>
        </div>
    </div>
</template>

<script>
import Mypage from "@/api/mypage/Mypage.js"

export default {
    name: 'PopUp',
    props: {
        'programIdTo': Number,
    },
    data() {
        return {
            programId: '',
            reason: '',
        }
    },
    mounted() {
        this.programId = this.programIdTo;
    },
    watch: {
        programIdTo() {
            this.programId = this.programIdTo;
        },
    },
    methods: {
        destroy() {
            let data = {
                    reason: this.reason,
                };

            var comfirm = document.getElementById('refund_confirm');
            comfirm.disabled = true;

            Mypage.destroy(this.programId, data).then(res => {
                alert(res.data.msg);
                this.$emit('close');
                window.location.reload()
            }).catch(err => {
                alert(err);
                comfirm.disabled = true;
            });
        }
    }
}
</script>

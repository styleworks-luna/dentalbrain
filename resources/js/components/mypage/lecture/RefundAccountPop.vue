<template>
    <div class="account-pop-up">
        <h3>강의 신청취소 안내</h3>
        <p>강의 신청을 취소하시겠습니까?</p>
        <div class="btn-wrap">
            <button id="refund_confirm" @click.prevent="destroy">확인</button>
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
            var comfirm = document.getElementById('refund_confirm');
            comfirm.disabled = true;

            Mypage.destroy(this.programId).then(res => {
                alert(res.data.msg);
                this.$emit('close');
                window.location.reload()
            }).catch(err => {
                comfirm.disabled = true;
            });
        }
    }
}
</script>

<template>
    <layout title="추가 정보 입력">
        <template v-slot:body>
            <ul>
                <li></li>
            </ul>
        </template>
    </layout>
</template>

<script>
import Common from '@/api/admin/lecture/Common.js'
export default {
    name: 'AdminOnlineAdditional',
    data() {
        return {
            program_id: '',
            student_id: '',
        }
    },
    mounted() {
        this.getData();
    },
    created() {
        this.program_id = this.$route.params.program_id;
        this.student_id = this.$route.params.student_id;
    },
    methods: {
        getData(page = this.page) {
            Common.getAdditional(this.program_id,this.student_id).then(res => {
                console.log(res)
            }).catch(err => {
            });
        },
    }
}
</script>

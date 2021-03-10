<template>
    <layout title="추가 정보 입력">
        <template v-slot:body>
            <ul>
                <li v-for="survey in surveys">
                    {{ survey.question }}
                </li>
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
            surveys: []
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
                this.surveys = res.data.result;
            }).catch(err => {
            });
        },
    }
}
</script>

<template>
    <layout title="강의 질문내역">
        <template v-slot:body>
            <table-grid :tableCol="tableCol"
                        :data="questions.data">
                <template v-slot:list="slotProps">

                </template>
            </table-grid>

            <div class="paging-wrap text-center">
                <nav class="d-inline-block">
                    <pagination :data="questions" @pagination-change-page="getData" class="mb-0">
                        <span slot="prev-nav">‹</span>
                        <span slot="next-nav">›</span>
                    </pagination>
                </nav>
            </div>
        </template>
    </layout>
</template>

<script>
    // component
    import Table from '@/components/admin/grid/Table.vue';

    export default {
        name: 'AdminQuestion',
        components: {
            'table-grid': Table
        },
        data() {
            return {
                questions: {
                    data: []
                },
                page: 1
            }
        },
        computed: {
            tableCol() {
                return [
                    {
                        name: 'id',
                        text: '번호'
                    },
                    {
                        name: 'user_id',
                        text: '아이디'
                    },
                    {
                        name: 'email',
                        text: '이메일'
                    },
                    {
                        name: 'title',
                        text: '강의제목'
                    },
                    {
                        name: 'content',
                        text: '질문내용'
                    },
                    {
                        name: 'is_answer',
                        text: '답변여부'
                    },
                    {
                        name: 'question_date',
                        text: '질문일시'
                    }
                ]
            }
        },
        methods: {
            getData(page = this.page) {
                if (this.Helper.nullCheck(page)) {
                    page = 1;
                }

                let params = {
                    page: page
                };

                Faq.getData(params).then(res => {
                    this.lectures = res.data.question;
                }).catch(err => {
                    this.questions = [];
                });
            },
        }
    }
</script>

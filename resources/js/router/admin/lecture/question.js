import Question from '@/views/admin/lecture/Question.vue';
import QuestionEdit from '@/views/admin/lecture/QuestionEdit.vue';

const routes = [
    {
        path: '/admin/lecture/question',
        name: 'AdminQuestion',
        component: Question
    },
    {
        path: '/admin/lecture/question/:id',
        name: 'AdminQuestionEdit',
        component: QuestionEdit
    },
];

export default routes;

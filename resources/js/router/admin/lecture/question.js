import Question from '@/views/admin/lecture/Question.vue';
import QuestionEdit from '@/views/admin/lecture/QuestionEdit.vue';

const routes = [
    {
        path: '/admin/lecture/question/:page',
        name: 'AdminQuestion',
        component: Question
    },
    {
        path: '/admin/lecture/question/:id/:page',
        name: 'AdminQuestionEdit',
        component: QuestionEdit
    },
];

export default routes;

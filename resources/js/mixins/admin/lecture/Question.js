// components
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';

// 질문내역 수정
export const QuestionMixin = {
    components: {
        'single-group': SingleGroup,
        'button-check': ButtonCheck,
        'select-box': SelectBox
    },
    data() {
        return {
            is_answer: 0,
            answerOption:[
                {
                    id: 0,
                    name: '미완료'
                },
                {
                    id: 1,
                    name: '완료'
                }
            ]
        }
    },
    methods: {
        handleSetAnswerId(value) {
            this.is_answer = value;
        },
    }
};

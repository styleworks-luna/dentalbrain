// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';

// faq 생성, 수정
export const FaqMixin = {
    components: {
        'single-group': SingleGroup,
        'button-check': ButtonCheck,
        'select-box': SelectBox
    },
    data() {
        return {
            question: '',
            answer: '',
            category_id: 1,
            is_open: false,
            categoryOptions: [
                {
                    id: 1,
                    name: 'asd'
                },
                {
                    id: 2,
                    name: '123'
                }
            ]
        }
    },
    methods: {
        handleSetCategoryId(value) {
            this.category_id = value;
        },
        handleSetIsOpen(checked) {
            this.is_open = checked;
        }
    }
};

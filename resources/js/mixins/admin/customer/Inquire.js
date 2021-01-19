// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';

// api
import Inquire from '@/api/admin/customer/Inquire.js';

// 문의하기 수정
export const InquireMixin = {
    components: {
        'single-group': SingleGroup,
        'button-check': ButtonCheck,
        'select-box': SelectBox
    },
    data() {
        return {
            category_id: 1,
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
            ],
            categoryOptions: []
        }
    },
    mounted() {
        this.getCategory();
    },
    methods: {
        handleSetCategoryId(value) {
            this.category_id = value;
        },
        handleSetAnswerId(value) {
            this.is_answer = value;
        },
        getCategory() {
            Inquire.getCategory().then(res => {
                const result = res.data.category;

                this.categoryOptions = result;
            });
        },
    }
};

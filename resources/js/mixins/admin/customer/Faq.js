// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';

// api
import Faq from '@/api/admin/customer/Faq.js';

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
        handleSetIsOpen(checked) {
            this.is_open = checked;
        },
        getCategory() {
            Faq.getCategory().then(res => {
                const result = res.data.faqCategory;

                this.categoryOptions = result;
            });
        }
    }
};

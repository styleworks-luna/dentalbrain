// component
import FormSingleGroup from '@/components/admin/grid/FormSingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';

// faq 생성, 수정
export const NoticeMixin = {
    components: {
        'form-single-group': FormSingleGroup,
        'button-check': ButtonCheck,
        'select-box': SelectBox
    },
    data() {
        return {
            title: '',
            content: '',
            is_open: false,
        }
    },
    methods: {
        handleSetIsOpen(checked) {
            this.is_open = checked;
        }
    }
};

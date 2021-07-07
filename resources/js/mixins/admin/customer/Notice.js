// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';
import Editor from '@/components/admin/form/Editor.vue';

// Notice 생성, 수정
export const NoticeMixin = {
    components: {
        'single-group': SingleGroup,
        'button-check': ButtonCheck,
        'select-box': SelectBox,
        Editor
    },
    data() {
        return {
            title: '',
            content: '',
            display_name:'',
            is_open: false,
        }
    },
    methods: {
        handleSetIsOpen(checked) {
            this.is_open = checked;
        },
        handleSetEditor(data) {
            this.content = data;
        },
    }
};

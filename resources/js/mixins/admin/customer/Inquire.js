// component
import Table from '@/components/admin/grid/Table.vue';
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';

// 문의하기 수정
export const InquireMixin = {
    components: {
        'table-grid': Table,
        'single-group': SingleGroup,
        'button-check': ButtonCheck,
        'select-box': SelectBox
    },
    data() {
        return {

        }
    },
    methods: {
    }
};

// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ImageUpload from '@/components/admin/form/ImageUpload.vue';
import DatePicker from '@/components/common/DatePicker.vue';
import SelectBox from '@/components/common/SelectBox.vue';
import Editor from '@/components/admin/form/Editor.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';

// api
import Community from '@/api/admin/community/Community.js';

// 배너 수정,생성
export const CommunityMixin = {
    components: {
        'single-group': SingleGroup,
        'image-upload': ImageUpload,
        'date-picker': DatePicker,
        Editor,
        SelectBox,
        ButtonCheck,
    },
    data() {
        return {
            id: '',
            title: '',
            category_id: '',
            categoryOptions: [],
            date: '',
            content: '',
            writer: '',
            is_open: '',
        }
    },
    mounted() {
      this.getCategory()
    },
    methods: {
        updateThumbnail (data) {
            this.thumbnail = data;
        },
        handleSetEditor(data) {
            this.content = data;
        },
        handleSetCategoryId(id) {
            this.category_id = id;
        },
        handleSetIsOpen(checked) {
            this.is_open = checked;
        },
        getCategory() {
            Community.getCategory().then(res => {
                const option = res.data[0];

                this.categoryOptions = option;
            });
        },
    }
};

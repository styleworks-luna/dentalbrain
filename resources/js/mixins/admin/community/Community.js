// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ImageUpload from '@/components/admin/form/ImageUpload.vue';
import DatePicker from '@/components/common/DatePicker.vue';
import Editor from '@/components/admin/form/Editor.vue';

// 배너 수정,생성
export const CommunityMixin = {
    components: {
        'single-group': SingleGroup,
        'image-upload': ImageUpload,
        'date-picker': DatePicker,
        Editor,
    },
    data() {
        return {
            id: '',
            title: '',
            link: '',
            date: '',
            thumbnail: '',
            content: '',
        }
    },
    methods: {
        updateThumbnail (data) {
            this.thumbnail = data;
        },
        handleSetEditor(data) {
            this.content = data;
        },
    }
};

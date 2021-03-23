// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ImageUpload from '@/components/admin/form/ImageUpload.vue';
import DatePicker from '@/components/common/DatePicker.vue';

// 배너 수정,생성
export const CommunityMixin = {
    components: {
        'single-group': SingleGroup,
        'image-upload': ImageUpload,
        'date-picker': DatePicker,
    },
    data() {
        return {
            id: '',
            title: '',
            link: '',
            date: '',
            thumbnail: '',
        }
    },
    methods: {
        updateThumbnail (data) {
            this.thumbnail = data;
        },
    }
};

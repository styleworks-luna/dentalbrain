// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';
import ImageUpload from '@/components/common/ImageUpload.vue';
import DatePicker from '@/components/common/DatePicker.vue';

// 배너 수정,생성
export const BannerMixin = {
    components: {
        'single-group': SingleGroup,
        'button-check': ButtonCheck,
        'select-box': SelectBox,
        'image-upload': ImageUpload,
        'date-picker': DatePicker,
    },
    data() {
        return {
            title: '',
            link: '',
            position: 0,
            started_at: '',
            ended_at: '',
            order: 0,
            is_open: 0,
            desktop_file: '',
            mobile_file: '',
            orderOptions:[
                {
                    id: 0,
                    name: 0
                },
                {
                    id: 1,
                    name: 1
                },
                {
                    id: 2,
                    name: 2
                },
                {
                    id: 3,
                    name: 3
                },
                {
                    id: 4,
                    name: 4
                },
                {
                    id: 5,
                    name: 5
                },

            ],
            bannerOptions: [
                {
                    id: 0,
                    name: '상단배너'
                },
                {
                    id: 1,
                    name: '바배너'
                },
                {
                    id: 2,
                    name: '추천배너'
                },
                {
                    id: 3,
                    name: '하단배너'
                },
            ],

        }
    },
    mounted() {

    },
    methods: {
        handleSetBannerCategoryId(value) {
            this.position = value;
        },
        handleSetOrderCategoryId(value) {
            this.order = value;
        },
        handleSetIsOpen(checked) {
            this.is_open = checked;
        },
        updateDesktopFile (data) {
            this.desktop_file = data;
        },
        updateMobileFile (data) {
            this.mobile_file = data;
        }
    }
};

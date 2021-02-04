// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ImageUpload from '@/components/admin/form/ImageUpload.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';
import DatePicker from '@/components/common/DatePicker.vue';

// api
import Banner from '@/api/admin/banner/Banner.js';

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
            ]
        }
    },
    methods: {
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

export const BannerCategoryMixin = {
    data() {
        return {
            category_id: 1,
            bannerOptions: []
        }
    },
    mounted() {
        this.getCategoryData();
    },
    methods: {
        getCategoryData() {
            Banner.getCategoryData().then(res => {
                this.bannerOptions = res.data.category;
            })
        },
        handleSetCategoryId(value) {
            this.category_id = value;
        }
    }
}
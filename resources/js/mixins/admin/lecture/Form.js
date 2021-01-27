// components
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import Thumbnail from '@/components/admin/form/Thumbnail.vue';
import Editor from '@/components/admin/form/Editor.vue';
import AdditionalInformation from '@/components/admin/form/AdditionalInformation.vue'
import SelectBox from '@/components/common/SelectBox.vue';

// api
import Common from '@/api/admin/lecture/Common.js';

//
export const LectureFormMixin = {
    components: {
        'single-group': SingleGroup,
        'select-box': SelectBox,
        'thumbnail': Thumbnail,
        'editor': Editor,
        'additional-information': AdditionalInformation,
    },
    data() {
        return {
            thumbnail: {},
            major_category_id: '',
            minor_category_id: '',
            title: '',
            lecture_info: '',
            description: '',
            is_free: true,
            price: '',
            content: '',
            surveys: [],
            majorCategoryOptions: [],
            minorCategoryOptions: []
        }
    },
    mounted() {
            this.getCategory();
    },
    computed: {
    },
    methods: {
        handleSetThumbnail(file) {
            this.thumbnail = file;
        },

        handleSetMajorCategoryId(id) {
            this.major_category_id = id;
        },
        handleSetMinorCategoryId(id) {
            this.minor_category_id = id;
        },
        handleSetEditor(data) {
            this.content = data;
        },
        getCategory() {
            Common.getCategory().then(res => {
                const major = res.data.major;
                const minor = res.data.minor;

                this.majorCategoryOptions = major;
                this.minorCategoryOptions = minor;
            });
        }
    }
};

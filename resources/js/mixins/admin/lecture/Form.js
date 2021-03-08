// components
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import Thumbnail from '@/components/admin/form/Thumbnail.vue';
import Editor from '@/components/admin/form/Editor.vue';
import AdditionalInformation from '@/components/admin/form/AdditionalInformation.vue'
import SelectBox from '@/components/common/SelectBox.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';

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
        'button-check': ButtonCheck,
    },
    data() {
        return {
            thumbnail: {},
            title: '',
            lecture_info: '',
            is_free: true,
            price: '',
            content: '',
            surveys: [],
            is_open: false,
            haveStudents: '',
        }
    },
    computed: {
    },
    methods: {
        handleSetThumbnail(file) {
            this.thumbnail = file;
        },
        handleSetEditor(data) {
            console.log('emit data----------');
            console.log(data);
            this.content = data;
        },
        handleSetIsOpen(checked) {
            this.is_open = checked;
        },
    }
};

export const ProgramCategoryMixin = {
    data() {
        return {
            major_category_id: '',
            minor_category_id: '',
            majorCategoryOptions: [],
            minorCategoryOptions: [],
        }
    },
    mounted() {
        this.getCategory();
    },
    methods: {
        getCategory() {
            Common.getCategory().then(res => {
                const major = res.data.major;
                const minor = res.data.minor;

                this.majorCategoryOptions = major;
                this.minorCategoryOptions = minor;
            });
        },
        handleSetMajorCategoryId(id) {
            this.major_category_id = id;
        },
        handleSetMinorCategoryId(id) {
            this.minor_category_id = id;
        },
    },
};

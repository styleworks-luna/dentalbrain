// components
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import Thumbnail from '@/components/admin/form/Thumbnail.vue';
import Editor from '@/components/admin/form/Editor.vue';
import AdditionalInformation from '@/components/admin/form/AdditionalInformation.vue'
import SelectBox from '@/components/common/SelectBox.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';

// api
import Common from '@/api/admin/lecture/Common.js';
import Certificate from '@/api/admin/certificate/Certificate.js'

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
            is_discount: false,
            membership_is_discount: false,
            membership_is_free: true,
            price: '',
            discounted_price: '',
            discount_rate: '',
            membership_price: '',
            membership_discounted_price: '',
            membership_discount_rate: '',
            content: '',
            surveys: [],
            is_open: false,
            haveStudents: '',
        }
    },
    computed: {},
    methods: {
        handleSetThumbnail(file) {
            this.thumbnail = file;
        },
        handleSetEditor(data) {
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

export const ProgramCertificateCategoryMixin = {
    data() {
        return {
            certification_id: '',
            completion_id: '',
            certificationOptions: [],
            completionOptions: [],
        }
    },
    mounted() {
        this.getCertificationCategory();
    },
    methods: {
        getCertificationCategory() {
            Certificate.getOptions().then(res => {
                res.data.qualifications.forEach(x => {
                    this.certificationOptions.push({
                        id: x.id,
                        name: x.title
                    });
                })
                res.data.completions.forEach(x => {
                    this.completionOptions.push({
                        id: x.id,
                        name: x.title
                    });
                })
            })
        },
        handleSetCertificateCategoryId(id) {
            this.certification_id = id;
        },
        handleSetCompletionCategoryId(id) {
            this.completion_id = id;
        },
    }
}

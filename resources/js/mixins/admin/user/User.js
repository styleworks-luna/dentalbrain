// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import SelectBox from '@/components/common/SelectBox.vue';

//api
import User from '@/api/admin/user/User.js';

// 문의하기 수정
export const UserMixin = {
    components: {
        'single-group': SingleGroup,
        'button-check': ButtonCheck,
        'select-box': SelectBox
    },
    data() {
        return {
            login_id: '',
            name: '',
            email: '',
            phone: '',
            job_id: 1,
            license_num: '',
            allow_email: false,
            jobOptions: [],
        }
    },
    mounted() {
        this.getCategory();
    },
    methods: {
        getCategory() {
            User.getCategory().then(res => {
                const result = res.data.userJob;

                this.jobOptions = result;
            });
        },
        handleSetJobyId(value) {
            this.job_id = value;
            console.log(this.job_id);
        },
    }
};

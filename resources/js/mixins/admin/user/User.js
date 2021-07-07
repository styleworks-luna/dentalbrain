// component
import SingleGroup from '@/components/admin/form/SingleGroup.vue';
import ButtonCheck from '@/components/admin/button/ButtonCheck.vue';
import DatePicker from '@/components/common/DatePicker.vue'
import TimePicker from '@/components/common/TimePicker.vue'
import SelectBox from '@/components/common/SelectBox.vue';

//api
import User from '@/api/admin/user/User.js';

// 문의하기 수정
export const UserMixin = {
    components: {
        'single-group': SingleGroup,
        'button-check': ButtonCheck,
        'select-box': SelectBox,
        DatePicker,
        TimePicker,
    },
    data() {
        return {
            login_id: '',
            name: '',
            email: '',
            phone: '',
            memberships: [],
            memberships_dates: [],
            has_membership: false,
            job_name_id: 1,
            license_num: '',
            area: '',
            allow_email: false,
            allow_sms: false,
            jobOptions: [],
            is_paid: false,
            index: 0,
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
            this.job_name_id = value;
        },
        handleSetStartDate(time, idx) {
            this.memberships_dates[idx].start_date = time;
        },
        handleSetStartTime(time, idx) {
            this.memberships_dates[idx].start_time = time;
        },
        handleSetEndDate(time,idx) {
            this.memberships_dates[idx].end_date = time;
        },
        handleSetEndTime(time,idx) {
            this.memberships_dates[idx].end_time = time;
        },
    }
};

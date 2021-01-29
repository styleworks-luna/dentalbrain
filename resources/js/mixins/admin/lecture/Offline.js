// components
import DatePicker from '@/components/common/DatePicker.vue'
import TimePicker from '@/components/common/TimePicker.vue'
import NaverMap from '@/components/common/NaverMap.vue';

// 오프라인 강의 생성,수정
export const OfflineMixin = {
    components: {
        'date-picker': DatePicker,
        'time-picker': TimePicker,
        'naver-map': NaverMap,
    },
    data() {
        return {
            started_date: '',
            started_time: '',
            ended_date: '',
            ended_time: '',

            receipt_started_date: '',
            receipt_started_time: '',
            receipt_ended_date: '',
            receipt_ended_time: '',

            offline_programs: {
                started_at: '',
                ended_at: '',

                capacity: '',
                receipt_started_at: '',
                receipt_ended_at: '',

                address: '',
                address_detail: '',
                latitude: 37.487935,
                longitude: 126.857758,
                sido: '',
                gugun: '',
                dong: ''
            }
        }
    },
    methods: {
        handleSetStartDate(time) {
            this.started_date =  time;
        },
        handleSetStartTime(time) {
            this.started_time = time;
        },
        handleSetEndDate(time) {
            this.ended_date = time;
        },
        handleSetEndTime(time) {
            this.ended_time = time;
        },
        handleSetReceiptStartDate(time) {
            this.receipt_started_date = time;
        },
        handleSetReceiptStartTime(time) {
            this.receipt_started_time = time;
        },
        handleSetReceiptEndDate(time) {
            this.receipt_ended_date = time;
        },
        handleSetReceiptEndTime(time) {
            this.receipt_ended_time = time;
        },
        handleSetAddress(address) {
            this.offline_programs.address = address;
        },
        handleSetAddressDetail(addressDetail) {
            this.offline_programs.address_detail = addressDetail;
        },
        handleSetProgram(data) {
            this.offline_programs.latitude = data.latitude;
            this.offline_programs.longitude = data.longitude;
            this.offline_programs.sido = data.sido;
            this.offline_programs.gugun = data.gugun;
            this.offline_programs.dong = data.dong;
        }
    }
};

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

            program_place: {
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
            this.program_place.address = address;
        },
        handleSetAddressDetail(addressDetail) {
            this.program_place.address_detail = addressDetail;
        },
        handleSetProgram(data) {
            this.program_place.latitude = data.latitude;
            this.program_place.longitude = data.longitude;
            this.program_place.sido = data.sido;
            this.program_place.gugun = data.gugun;
            this.program_place.dong = data.dong;
        }
    }
};

// component
import FileUpload from '@/components/admin/form/FileUpload.vue';

// 온라인 강의 생성,수정
export const OnlineMixin = {
    components: {
        'file-upload': FileUpload,
    },
    data() {
        return {
            material: '',
            running_time: '',
            lectures: [
                {
                    title: '',
                    link: '',
                    thumbnail: {}
                },
            ]
        }
    },
    mounted() {

    },
    computed: {
    },
    methods: {
        addLecture() {
            this.lectures.push({
                title: '',
                link: '',
                thumbnail: '',
            })
        },
        updateLectureFile (file, index) {
            this.lectures[index].thumbnail = file;
        },
        updateFile (data) {
            this.material = data;
        },
    }
};

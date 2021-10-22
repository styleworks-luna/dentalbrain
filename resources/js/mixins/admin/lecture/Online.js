
// component
import FileUpload from '@/components/admin/form/FileUpload.vue';

// 온라인 강의 생성,수정
export const OnlineMixin = {
    components: {
        'file-upload': FileUpload,
    },
    computed: {
        VideoOptions() {
            return [
                {
                    id: 'youtube',
                    name: '유뷰트'
                },
                {
                    id: 'wecandeo',
                    name: 'wecandeo',
                }
            ]
        }
    },
    data() {
        return {
            material: '',
            running_time: '',
            lectures: [
                {
                    title: '',
                    url: '',
                    video_type: '',
                    thumbnail: {

                    }
                },
            ],
        }
    },
    methods: {
        addLecture() {
            this.lectures.push({
                title: '',
                link: '',
                thumbnail: '',
            })
        },
        removeLecture(index) {
            this.lectures.splice(index, 1);
        },
        updateLectureFile (file, index) {
            this.lectures[index].thumbnail = file;
        },
        updateFile (data) {
            this.material = data;
        },
        handleSetVideo (id, idx) {
            this.lectures[idx].video_type = id;
        }
    }
};


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
                    name: 'youtube'
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
                    video_type: 'youtube',
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
                video_type: 'youtube',
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
        },
        handleSetPreview (id, idx) {
            this.preview_type = id;
        }
    }
};

// component
import FileUpload from '@/components/admin/form/FileUpload.vue';
import Certificate from '@/api/admin/certificate/Certificate.js'

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
    mounted() {
        this.getCertificationCategory();
    },
    data() {
        return {
            material: '',
            running_time: '',
            preview_url: '',
            preview_type: 'youtube',
            term: '',
            lectures: [
                {
                    title: '',
                    url: '',
                    video_type: 'youtube',
                    thumbnail: {}
                },
            ],
            certification_id: '',
            completion_id: '',
            certificationOptions: [],
            completionOptions: [],
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
        updateLectureFile(file, index) {
            this.lectures[index].thumbnail = file;
        },
        updateFile(data) {
            this.material = data;
        },
        handleSetVideo(id, idx) {
            this.lectures[idx].video_type = id;
        },
        handleSetPreview(id) {
            this.preview_type = id;
        },
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
};

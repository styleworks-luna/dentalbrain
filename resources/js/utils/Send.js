import axios from 'axios';

const instance = axios.create({
    baseURL: '/',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

instance.interceptors.request.use(
    (config) => {
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

instance.interceptors.response.use(
    (response) => {
        return response;
    },


    (error) => {
        if (error.response.status == 422) {
            var errors = error.response.data.errors;

            if(errors.title) {
                errors.title[0] = '제목을 입력해주세요.'
            }
            if(errors.content) {
                errors.content[0] = '내용을 입력해주세요.'
            }
            if(errors.major_category_id) {
                errors.major_category_id[0] = '대분류를 선택해주세요.'
            }
            if(errors.minor_category_id) {
                errors.minor_category_id[0] = '소분류를 선택해주세요.'
            }
            if(errors.thumbnail_id) {
                errors.thumbnail_id[0] = '자료를 선택해주세요.'
            }
            if(errors.running_time) {
                errors.running_time[0] = '강의시간을 입력해주세요.'
            }
            if (errors.question) {
                errors.question[0] = '질문을 입력해주세요.'
            }
            if (errors.answer) {
                errors.answer[0] = '답변을 입력해주세요.'
            }
            if (errors.display_name) {
                errors.display_name[0] = '작성자를 입력해주세요.'
            }
            if (errors.link) {
                errors.link[0] = '연결주소를 입력해주세요.'
            }
            if (errors.mobile_file_id) {
                errors.mobile_file_id[0] = '모바일 이미지를 선택해주세요.'
            }
            if (errors.desktop_file_id) {
                errors.desktop_file_id[0] = 'PC 이미지를 선택해주세요.'
            }
            if (errors.started_at) {
                errors.started_at[0] = '노출기간을 선택해주세요.'
            }
            if (errors.ended_at) {
                errors.ended_at[0] = '노출기간 종료 날짜를 시작 날짜 전으로 선택해주세요.'
            }

            alert(JSON.stringify(errors, null, 2))
        } else {
            alert('오류');
        }
        return Promise.reject(error);
    }
);


export default instance;

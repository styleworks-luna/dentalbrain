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

            alert(Object.values(errors).join('\n'));
        } else {
            alert('오류');
        }
        return Promise.reject(error);
    }
);


export default instance;

import Send from '@/utils/Send.js';

export default {
    fileUpload(data) {
        return Send({
            url: '/api/admin/upload/file',
            method: 'post',
            data: data
        });
    },
    imageUpload(data) {
       return Send({
           url: '/api/admin/upload/image',
           method: 'post',
           data: data
       });
    },
}

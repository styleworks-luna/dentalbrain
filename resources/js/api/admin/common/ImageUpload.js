import Send from '@/utils/Send.js';

export default {
    fileUpload(data) {
       return Send({
           url: '/api/admin/upload/image',
           method: 'post',
           data: data
       });
    }
}

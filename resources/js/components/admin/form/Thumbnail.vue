<template>
    <div class="thumbnail-wrap"
         :style="thumbnailPreview">
        <input type="file" class="d-none" :id="id"
               @change="fileUpload"
               accept=".JPG, .JPEG, .PNG, .GIF">
        <label class="btn btn-block btn-info"
               :for="id">
            썸네일 변경
        </label>
    </div>
</template>

<script>
    export default {
        name: 'FileThumbnail',
        props: {
            id: String,
            file: Object
        },
        computed: {
            thumbnailPreview() {
                return {
                    backgroundImage: `url(${this.file.url})`
                };
            }
        },
        methods: {
            fileUpload(e) {
                let uploadForm = new FormData();
                uploadForm.append('image', e.target.files[0]);

                axios.post(`/api/admin/upload/image`, uploadForm).then(res => {
                    this.$emit('setFile', res.data.file);
                    uploadForm = null;
                }).catch(err => {
                    alert('오류');
                });
            }
        }
    }
</script>

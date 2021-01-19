<template>
    <div class="file-wrap"
         :style="{ backgroundImage: Helper.thumbnail(file) }">
        <input type="file" class="d-none" :id="id"
               @change="fileUpload">
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
        methods: {
            fileUpload(e) {
                let uploadForm = new FormData();
                uploadForm.append('thumbnail', e.target.files[0]);

                axios.post(`/api/thumbnail/store`, uploadForm).then(res => {
                    this.$emit('setFile', res.data.file);
                }).catch(err => {
                    alert('오류');
                });
            }
        }
    }
</script>

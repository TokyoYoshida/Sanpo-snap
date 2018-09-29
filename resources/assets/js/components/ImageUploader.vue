
<template>
    <div>
        <vue-dropzone
            ref="myVueDropzone"
            id="dropzone"
            :options="dropzoneOptions"
            v-on:vdropzone-success="onSuccess"
            v-on:vdropzone-error="onError"
            v-on:vdropzone-files-added="onFilesAdded">
        </vue-dropzone>
        <input type="hidden" name="filename" class="form-control" :value="filename">
        <input type="hidden" name="photo_uploaded" class="form-control" :value="uploaded">
    </div>
</template>

<style>
</style>

<script>
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        props: {
            defaultFilename: String,
            photoUploaded: String
        },
        mounted() {
            if(this.defaultFilename !== "") {
                this.file = {size: 123, name: "Icon", type: "image/png"};
                this.filename = this.defaultFilename;
                var url;
                if(this.photoUploaded === "1") {
                    url = "/storage/tmp/" + this.defaultFilename;
                } else {
                    url = "/storage/photo/" + this.defaultFilename;
                }

                this.$refs.myVueDropzone.manuallyAddFile(this.file, url);
            }
            this.uploaded = this.photoUploaded;
        },
        components: {
            vueDropzone: require('vue2-dropzone')
        },
        data: function () {
            return {
                filename: '',
                uploaded: 0,
                file: null,
                dropzoneOptions: {
                    url: '/api/photo_image',
                    thumbnailWidth: 300,
                    maxFilesize: 2,
                    headers: { 'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content},
                    maxFiles: 1,
                    clickable: true
                }
            }
        },
        methods: {
            onFilesAdded: function (file) {
                if(this.file) {
                    this.$refs.myVueDropzone.removeFile(this.file);
                }
            },
            onError: function (file, message, xhr){
                this.file = file;
                this.filename = "";
            },
            onSuccess: function (file,response) {
                this.filename = response;
                this.file = file;
                this.uploaded = 1;
            }
        }
    }
</script>


<template>
    <div ref="imageUploader">
        <vue-dropzone
            ref="myVueDropzone"
            id="dropzone"
            :options="dropzoneOptions"
            v-on:vdropzone-success="onSuccess"
            v-on:vdropzone-error="onError"
            v-on:vdropzone-files-added="onFilesAdded"
            v-on:vdropzone-removed-file="onRemoved"
        >
        </vue-dropzone>

        <input type="hidden" name="image_filename" class="form-control" :value="filename">
        <input type="hidden" name="image_uploaded" class="form-control" :value="uploaded">

        <div class="alert alert-danger" v-if="errors">
            <ul>
                <li v-for="(error, index) in errors">
                    {{ error }}
                </li>
            </ul>
        </div>
    </div>
</template>

<style>
    #dropzone {
        text-align: center;
    }
    #dropzone .dz-preview {
        display: flex;
        align-items: center;
    }

    #dropzone .dz-preview .dz-image {
        display: flex;
        justify-content: center;
    }
</style>

<script>
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        props: {
            defaultFilename: String,
            imageUploaded: String,
            imageDir: String,
            addRemoveLink: Boolean
        },
        mounted() {
            if(this.defaultFilename !== "") {
                this.file = {size: 123, name: "Icon", type: "image/png"};
                this.filename = this.defaultFilename;

                this.$refs.myVueDropzone.manuallyAddFile(this.file, this.getUrl(this.filename));
            }
            this.uploaded = this.imageUploaded;
        },
        components: {
            vueDropzone: require('vue2-dropzone')
        },
        data: function () {
            return {
                filename: '',
                uploaded: 0,
                file: null,
                errors: null,
                dropzoneOptions: {
                    url: '/api/image',
                    maxFilesize: 20,
                    headers: { 'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content},
                    maxFiles: 1,
                    clickable: true,
                    addRemoveLinks: this.addRemoveLink,
                    thumbnailMethod: 'contain',
                }
            }
        },
        methods: {
            getUrl: function(filename) {
                if(this.imageUploaded === "1") {
                    return "/storage/tmp/" + this.defaultFilename;
                }
                return this.imageDir + this.defaultFilename;
            },
            onFilesAdded: function (file) {
                if(this.file) {
                    this.$refs.myVueDropzone.removeFile(this.file);
                }
            },
            onError: function (file, message, xhr){
                this.file = file;
                this.filename = "";
                this.errors = message.errors.file;
            },
            onSuccess: function (file,response) {
                this.$refs.myVueDropzone.removeAllFiles();
                this.filename = response;
                this.file = file;
                this.uploaded = 1;
                this.errors = "";
                let url = "/storage/tmp/" + this.filename;
                this.$refs.myVueDropzone.manuallyAddFile(this.file, url);
            },
            onRemoved: function (file, error, xhr){
                this.filename = "";
                this.uploaded = 0;
                this.errors = "";
            }
        }
    }
</script>

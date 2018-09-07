<template>
    <div class="input-group custom-file-uploader">
        <label class="input-group-btn">
            <span class="btn btn-primary">
                選択<input @change="fileSelected" type="file" name="file">
            </span>
        </label>
        <input type="text" v-model="filename" class="form-control" readonly="" >
        <input type="submit" name="image-send-button" class="btn btn-primary input-group-addon" value="設定する">
    </div>
</template>

<style>
    input[type='file'] {
        display: none;
    }
    input[type='submit'] {
        height: 37px;
    }
</style>

<script>
    export default {
        data: function() {
            return {
                filename: '',
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            fileSelected: function(e) {
                e.preventDefault();
                let files = e.target.files;
                this.filename = files[0].name;
            }
        }
    }
</script>

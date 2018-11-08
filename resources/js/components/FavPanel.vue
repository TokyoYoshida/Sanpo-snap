<template>
    <div>
        <div class="row">
            <div class="col-md-12  d-flex justify-content-center">
                <button type="button" class="btn btn-primary" @click="onClick" :disabled="userId === null">
                    <div v-if="!isFaved">
                        お気に入りに登録する
                    </div>
                    <div v-else>
                        お気に入りを解除する
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>

<style>
</style>

<script>
    export default {
        props: {
            defaultIsFaved: Boolean,
            photoId: Number,
            userId: Number,
            isAuthed: Boolean,
        },
        data: function() {
            return {
                isFaved: false,
            }
        },
        mounted() {
            this.isFaved = this.defaultIsFaved == 1;
        },
        methods: {
            onClick: function(e) {
                if(!this.isFaved) {
                    axios("/api/users/" + this.userId + "/favs", {
                        method: 'post',
                        params: {photo_id: this.photoId},
                        withCredentials: true
                    }).then(response => {
                        this.isFaved = true;
                    });
                } else {
                    axios("/api/users/" + this.userId + "/favs", {
                        method: 'delete',
                        params: {photo_id: this.photoId},
                        withCredentials: true
                    }).then(response => {
                        this.isFaved = false;
                    });
                }
            }
        }
    }
</script>

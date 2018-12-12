<template>
    <div class="container photo-edit" v-if="currentPhoto">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-header border-0">写真</div>
                    <div class="card-body text-center">
                        <img :src="'/storage/photo/'+currentPhoto.photo.filename" class="preview-img">
                    </div>
                    <fav-panel
                        :default-is-faved="currentPhoto.is_faved"
                        :user-id="authUser ? authUser.id : null"
                        :photo-id="currentPhoto.photo.id">
                    </fav-panel>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-header border-0">'写真の情報'</div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="user" class="col-md-4 col-form-label text-md-right">ユーザー</label>

                            <div class="col-md-7 text-left">
                                <user-panel
                                    :id="currentPhoto.photo_user.id"
                                    :name="currentPhoto.photo_user.name"
                                    :icon-url="currentPhoto.photo_user.icon_file ? '/storage/avatar/'+currentPhoto.photo_user.icon_file : ''"
                                    :is-following="currentPhoto.is_following"
                                    :button-type="(authUser == null || authUser.id == currentPhoto.photo_user.id) ? 0 : (currentPhoto.is_following != null ?  2 : 1)"
                                >
                                </user-panel>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">タイトル</label>

                            <div class="col-md-6 d-flex align-items-center">
                                {{ currentPhoto.photo.title }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="comment" class="col-md-4 col-form-label text-md-right">コメント</label>

                            <div class="col-md-6 d-flex align-items-center">
                                {{ currentPhoto.comment }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sanpo_date" class="col-md-4 col-form-label text-md-right">散歩した日</label>

                            <div class="col-md-6 d-flex align-items-center">
                                {{ currentPhoto.photo.sanpo_date !== null ? currentPhoto.photo.sanpo_date: '' | formatdate }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-header border-0">場所</div>
                    <div class="card-body">
                        <map-pointer :default-maker="{lat: currentPhoto.photo.location_lat, lng: currentPhoto.photo.location_lng}">
                        </map-pointer>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0">
                    <div class="card-header border-0">コメント</div>

                    <div class="card-body">
                        <comment-panel
                            photo-id="currentPhoto.photo.id"
                            :auth-user-id="authUser ? authUser.id : null"
                        >
                        </comment-panel>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" v-if="authUser">
            <div class="col-md-12">
                <div class="card border-0">
                    <a class="btn btn-primary" :href="'/photos/edit/'+currentPhoto.photo.id">編集する</a>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
</style>

<script>
    import { mapActions } from 'vuex';
    import { mapState } from 'vuex';

    export default {
        mounted() {
            this.getCurrentPhoto(this.$route.params.id);
        },
        methods: {
            ...mapActions(['getCurrentPhoto'])
        },
        computed: {
            ...mapState(['authUser', 'currentPhoto'])
        }
    }
</script>

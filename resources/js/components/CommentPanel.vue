<template>
    <div>
        <ul>
            <li v-for="(comment, index) in comments" class="row">
                <div class="col-md-6 d-flex align-items-center">
                    {{ comment.comment }}
                </div>
                <div class="col-md-6">
                    <user-panel
                        :id="comment.user_id"
                        :name="comment.user_name"
                        :icon-url="'/storage/avatar/'+comment.user_icon_file"
                        :is-following="comment.follower_id !== null"
                        :button-type="(authUserId == null || authUserId == comment.user_id) ? 0 : (comment.follower != null ?  2 : 1)"
                    >
                    </user-panel>
                </div>
            </li>
        </ul>
    </div>
</template>

<style>
    ul li {
        list-style: none;
    }
</style>

<script>
    export default {
        props: {
            photoId: String,
            authUserId: Number,
        },
        data: function () {
            return {
                comments: null,
            }
        },
        mounted() {
            axios("/api/photos/" + this.photoId + "/comments", {
                method: 'get',
                params: null,
                withCredentials: true
            }).then(response => {
                this.comments = response.data;
            });
        },
        methods: {
            onChenge: function (followers) {
            }
        },
        computed: {
            icon_url: function () {
            }
        }
    }
</script>

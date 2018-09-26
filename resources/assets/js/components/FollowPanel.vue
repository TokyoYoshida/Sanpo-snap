<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 d-flex align-items-center">
                {{ followers }}
            </div>
            <div class="col-md-6 d-flex align-items-center">
                <button type="button" class="btn btn-primary" @click="follow" :disabled="isFollowing">
                    フォローする
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
            defaultFollowers: Number,
            defaultIsFollowing: Boolean,
            userId: String
        },
        data: function() {
            return {
                followers: null,
                isFollowing: false,
            }
        },
        mounted() {
            this.followers = this.defaultFollowers;
            this.isFollowing = this.defaultIsFollowing == 1;
        },
        methods: {
            follow: function(e) {
                axios("/api/users/" + this.userId + "/followers", {
                    method: 'post',
                    withCredentials: true
                }).then(response => {
                    this.followers = response.data[0];
                    this.isFollowing = true;
                });
            }
        }
    }
</script>

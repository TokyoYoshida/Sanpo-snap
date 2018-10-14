<template>
    <div>
        <div class="d-inline-block">
            <a :href="follower_url">
                {{ followers }}
            </a>
        </div>
        <div class="d-inline-block ml-4">
            <follow-button
                :default-is-following="isFollowing"
                :user-id="userId"
                :button-type="buttonType"
                @change-event="onChenge"
            >
            </follow-button>
        </div>
    </div>
</template>

<style>
</style>

<script>
    export default {
        components: {
            'follow-button': require('./FollowButton.vue')
        },
        props: {
            defaultFollowers: Number,
            isFollowing: Boolean,
            userId: Number,
            buttonType: Number
        },
        data: function() {
            return {
                followers: null,
            }
        },
        mounted() {
            this.followers = this.defaultFollowers;
        },
        methods: {
            onChenge: function(followers) {
                this.followers = followers;
            }
        },
        computed: {
            follower_url: function(){
                return "/users/" + this.userId + "/followers";
            }
        }
    }
</script>

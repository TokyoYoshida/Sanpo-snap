<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 d-flex align-items-center">
                {{ followers }}
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <follow-button
                    :default-is-following="isFollowing"
                    :user-id="userId"
                    :button-type="buttonType"
                    @change-event="onChenge"
                >
                </follow-button>
            </div>
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
        }
    }
</script>

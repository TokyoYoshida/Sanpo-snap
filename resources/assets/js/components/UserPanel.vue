<template>
    <div>
        <div class="row justify-content-center mt-2 mb-2">
            <div class="col-md-3">
            </div>
            <div class="col-md-1 left">
                <img :src="iconUrl" alt="avatar" class="rounded-circle icon"/>
            </div>
            <div class="col-md-3 text-left d-flex align-items-center">
                <a :href="'/user/' + id" class="ml-2">
                    {{ name }}さん
                </a>
            </div>
            <div class="col-md-5 text-left">
                <span class="ml-5">
                    <follow-button
                        :default-is-following="isFollowing"
                        :user-id="id"
                        :button-type="buttonType"
                    >
                    </follow-button>
                </span>
            </div>
        </div>
    </div>
</template>

<style>
    .icon {
        width: 50px;
        height: 50px;
        object-fit: cover;
    }
</style>

<script>
    export default {
        components: {
            'follow-button': require('./FollowButton.vue')
        },
        mounted() {
            console.log(this.buttonType);
        },
        props: {
            id: Number,
            name: String,
            iconUrl: String,
            isFollowing: Boolean,
            buttonType: Number
        },
    }
</script>

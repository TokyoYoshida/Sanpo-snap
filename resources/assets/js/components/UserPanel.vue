<template>
    <div class="row my-2 d-flex justify-content-start">
        <div class="col-md-2　d-flex align-items-center">
            <img :src="iconUrl" alt="avatar" class="rounded-circle icon"/>
        </div>
        <div class="col-md-5 d-flex align-items-center">
            <a :href="'/users/' + id" class="ml-2">
                {{ name }}さん
            </a>
        </div>
        <div class="col-md-5 d-flex align-items-center">
            <follow-button
                :default-is-following="isFollowing"
                :user-id="id"
                :button-type="buttonType"
            >
            </follow-button>
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
        props: {
            id: Number,
            name: String,
            iconUrl: String,
            isFollowing: Boolean,
            buttonType: Number
        },
    }
</script>

<template>
    <button type="button" class="btn btn-primary" @click="onClick" :disabled="buttonType == 0" v-bind:style="{display : displayType}">
        <div v-if="!isFollowing">
            フォローする
        </div>
        <div v-else>
            フォローを解除する
        </div>
    </button>
</template>

<style>
</style>

<script>
    export default {
        props: {
            defaultIsFollowing: Boolean,
            userId: Number,
            buttonType: Number // 0 = invisible, 1 = enable(don't follow), 2 = enable (follow)
        },
        data: function() {
            return {
                followers: null,
                isFollowing: false,
            }
        },
        mounted() {
            this.isFollowing = this.defaultIsFollowing == 1;
        },
        computed: {
            displayType: function () {
                return this.buttonType == 0 ? "none" : "inline";
            }
        },
        methods: {
            onClick: function(e) {
                if(!this.isFollowing) {
                    axios("/api/users/" + this.userId + "/followers", {
                        method: 'post',
                        withCredentials: true
                    }).then(response => {
                        this.$emit('change-event', response.data[0]);
                        this.isFollowing = true;
                    });
                } else {
                    axios("/api/users/" + this.userId + "/followers", {
                        method: 'delete',
                        withCredentials: true
                    }).then(response => {
                        this.$emit('change-event', response.data[0]);
                        this.isFollowing = false;
                    });
                }
            }
        }
    }
</script>

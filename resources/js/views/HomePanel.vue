<template>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="#tab1" class="nav-link active" data-toggle="tab" v-on:click="onClick">最新</a>
            </li>
            <li class="nav-item">
                <a href="#tab2" class="nav-link" data-toggle="tab" v-on:click="onClick">タイムライン</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="tab1" class="tab-pane active">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">最新の散歩</div>
                            <div class="card-body">
                                <photo-gallery
                                    :reflesh-toggle=onClickToggle
                                    :per-page=30
                                >
                                </photo-gallery>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-pane">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">フォローしている散歩</div>

                            <div class="card-body">
                                <div v-if="loading">loading...</div>
                                <photo-gallery
                                    v-if="!loading"
                                    type="3"
                                    :user_id=authUser.id
                                    :refresh-toggle=onClickToggle
                                    :per-page=30
                                >
                                </photo-gallery>
                            </div>
                        </div>
                    </div>
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
        data: function() {
            return {
                onClickToggle: false,
                auth_user_id: null,
            }
        },
        methods: {
            onClick: function (e) {
                this.onClickToggle = !this.onClickToggle;
            },
            ...mapActions({
                getUserInfo: 'getUserInfo',
                add: 'increment',
                searchSong: 'searchSong'
            })
        },
        computed: {
            ...mapState(['loading','authUser']),
            count() {
                return this.$store.state.count
            }
        }
    }
</script>

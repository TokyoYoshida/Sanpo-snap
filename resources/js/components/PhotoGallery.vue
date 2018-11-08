<template>
    <div>
        <div v-masonry transition-duration="0.0s" item-selector=".item" column-width="270" fit-width="true">
            <div v-masonry-tile class="item" v-for="(item, index) in blocks">
                <a :href="'/photos/' + item.id">
                    <img :src="'/storage/photo/' + item.filename">
                </a>
            </div>
        </div>
    </div>
</template>

<style>
    .item img {
        display: block;
        width: 266px;
    }
</style>

<script>
    import {VueMasonryPlugin} from 'vue-masonry';
    Vue.use(VueMasonryPlugin);

    export default {
        props: {
            type: String, // 0 or undefined = all, 1 = user owned photos, 2 = user fav photos, 3 = timeline
            user_id: String,
            refreshToggle: Boolean, // Refresh if there is a change regardless of the value
        },
        components: {
            vueDropzone: require('vue2-dropzone')
        },
        mounted() {
            let url = '/api/photos';
            switch (this.type) {
                case "1":
                    url = '/api/users/' + this.user_id + '/photos';
                    break;
                case "2":
                    url = '/api/users/' + this.user_id + '/favs';
                    break;
                case "3":
                    url = '/api/users/' + this.user_id + '/timeline';
                    break;
            }
            axios
                .get(url)
                .then(response => {
                    this.blocks = response.data;
                });
        },
        data: function() {
            return {
                blocks: null
            }
        },
        watch: {
            refreshToggle: function (newVal, oldVal) {
                this.$redrawVueMasonry();
            }
        }
    }
</script>

<template>
    <div>
        <div v-masonry
             transition-duration="0.0s"
             item-selector=".item"
             column-width="270"
             fit-width="true"
             v-infinite-scroll="loadMore"
             infinite-scroll-disabled="hasMore"
             infinite-scroll-distance="10"
            >
            <div v-masonry-tile class="item" v-for="(item, index) in blocks">
                <router-link :to="'/vue/photos/'+item.id" v-if="isSpa">
                    <img :src="'/storage/photo/' + item.filename +'?thumb'">
                </router-link>
                <a :href="'/photos/' + item.id" v-if="!isSpa">
                    <img :src="'/storage/photo/' + item.filename +'?thumb'">
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
    import InfiniteScroll from 'vue-infinite-scroll';

    Vue.use(VueMasonryPlugin);
    Vue.use(InfiniteScroll);

    export default {
        props: {
            type: String, // 0 or undefined = all, 1 = user owned photos, 2 = user fav photos, 3 = timeline
            user_id: Number,
            refreshToggle: Boolean, // Refresh if there is a change regardless of the value
            perPage: Number
        },
        data: function() {
            return {
                blocks: [],
                offset: 0,
            }
        },
        watch: {
            refreshToggle: function (newVal, oldVal) {
                this.$redrawVueMasonry();
            }
        },
        methods: {
            loadMore: function() {
                let url = '/api/photos';
                if(this.busy === true){
                    return;
                }
                this.busy = true;

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
                axios(url, {
                    params: {offset: this.offset, per_page: this.perPage},
                }).then(response => {
                        this.blocks = this.blocks.concat(response.data);
                        this.offset += this.perPage;
                        this.busy = false;
                    });
            },
        },
        computed: {
            isSpa: function () {
                return this.$route.path.match(/^\/vue\/.*/) !== null;
            }
        }
    }
</script>

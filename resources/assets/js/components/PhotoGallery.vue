<template>
    <div>
        <div v-masonry transition-duration="0.1s" item-selector=".item" column-width="270" fit-width="true">
            <div v-masonry-tile class="item" v-for="(item, index) in blocks">
                <img :src=item.filename>
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
    export default {
        mounted() {
            axios
                .get('/api/photos')
                .then(response => {
                    this.blocks = response.data;
                })
        },
        data: function() {
            return {
                blocks: null
            }
        }
    }
</script>

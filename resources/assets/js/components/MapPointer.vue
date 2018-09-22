<template>
    <div class="map-pointer row justify-content-start">
        <form onsubmit="return false;">
            <div class="search input-group">
                <input type="text" v-model="searchAddressInput" title="test" class="form-control">
                <input type="submit" v-on:click="searchLocation" class="btn btn-primary input-group-addon" value="検索">
            </div>
        </form>
        <GmapMap
            ref="mapRef"
            :center="{lat:currentLocation.lat, lng:currentLocation.lng}"
            :zoom="5"
            :options="{disableDefaultUI:true}"
            :clickable="true"
            map-type-id="terrain"
            style="width: 100%; height: 500px"
            @click="setMarker"
        >
            <GmapMarker
                :key="1"
                :position="marker"
                :clickable="true"
                :draggable="true"
                @click="center=m.position"
            />
        </GmapMap>
        <input type="hidden" name="lat" class="form-control" :value="marker.lat">
        <input type="hidden" name="lng" class="form-control" :value="marker.lng">
    </div>
</template>

<style>
</style>

<script>
    import * as VueGoogleMaps from 'vue2-google-maps'
    import {gmapApi} from 'vue2-google-maps'

    Vue.use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyC702A3NBc6fRv4YdrTMUnZurEDKgMf6TY',
            libraries: 'places'
        },
    });
    export default {
        props: {
            defaultMaker: Object,
        },
        mounted () {
            Vue.$gmapDefaultResizeBus.$emit('resize');
            if(this.defaultMaker) {
                this.marker = this.defaultMaker;
                this.$refs.mapRef.$mapPromise.then((map) => {
                    map.setZoom(15);
                    map.panTo(this.marker);
                })
            }
        },
        computed: {
            google: gmapApi
        },
        data: function() {
            return {
                marker: {lat: "", lng: ""},
                currentLocation : { lat : 37.4507313, lng : 139.8372331 },
                searchAddressInput: ''
            }
        },
        methods : {
            geolocation : function() {
                navigator.geolocation.getCurrentPosition((position) => {
                    this.currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                });
            },
            searchLocation: function () {
                let geocoder = new google.maps.Geocoder();
                geocoder.geocode({'address': this.searchAddressInput}, (results, status) => {
                    if (status === 'OK') {
                        this.currentLocation.lat = results[0].geometry.location.lat();
                        this.currentLocation.lng = results[0].geometry.location.lng();
                    }
                });
                this.$refs.mapRef.$mapPromise.then((map) => {
                    map.setZoom(15)
                })
            },
            setMarker: function (evt) {
                this.marker = {lat: evt.latLng.lat(), lng: evt.latLng.lng()};
            }
        }
    }
</script>

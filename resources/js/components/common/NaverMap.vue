<template>
    <div>
        <div class="overflow-hidden">
            <input type="text" class="form-control float-left w-75 mb-3" placeholder="장소명,주소를 입력해주세요.">
            <button class="btn btn-info float-right" @click="handleSearch">검색</button>
        </div>
        <div>
            <naver-maps
                :height="height"
                :mapOptions="mapOptions"
                :initLayers="initLayers"
                @load="onLoad">
                <naver-marker v-if="latLng.lat && latLng.lng" :lat="latLng.lat" :lng="latLng.lng" @load="onMarkerLoaded"/>
            </naver-maps>
        </div>
        <div>
            <input type="text" class="form-control w-75 mt-3" placeholder="나머지 주소를 입력해주세요.">
        </div>
    </div>
</template>

<script>
export default {
    name: 'NaverMap',
    data() {
        return {
            height: 500,
            marker: null,
            map: null,
            mapOptions: {
                lat: 37.487935,
                lng: 126.857758,
                zoom: 17,
                zoomControl: true,
                zoomControlOptions: {position: 1},
                mapTypeControl: true,
            },
            latLng: {
                lat: null,
                lng: null
            },
            initLayers: ['BACKGROUND', 'BACKGROUND_DETAIL', 'POI_KOREAN', 'TRANSIT', 'ENGLISH', 'CHINESE', 'JAPANESE']
        }
    },
    computed: {
    },
    methods: {
        onLoad(vue)
        {
            this.map = vue;
        },
        onMarkerLoaded(vue) {
            this.marker = vue.marker;
        },
        handleSearch() {
            this.latLng.lat = 37.487935;
            this.latLng.lng = 126.757758;
        }
    },
    mounted() {
    }
}
</script>

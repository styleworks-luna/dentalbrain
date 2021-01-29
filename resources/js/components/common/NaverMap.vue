<template>
    <article class="map-container">
        <div class="map-search-bar">
            <input type="text"
                   class="form-control float-left w-75 mb-3"
                   placeholder="장소명,주소를 입력해주세요."
                   :value="data.address"
                   @input="handleSetAddress">
            <button class="btn btn-info float-left mt-1 ml-3"
                    @click="handleSearch">검색</button>

            <ul class="search-list" v-if="searchLists.length > 0 && showSearchList">
                <li v-for="item in searchLists" @click="handleSetMap(item)">
                    {{ item.address }}
                </li>
            </ul>
        </div>
        <div>
            <naver-maps
                :height="height"
                :lat="latLng.lat" :lng="latLng.lng"
                :mapOptions="mapOptions"
                :initLayers="initLayers"
                @load="onLoad">
                <naver-marker v-if="latLng.lat && latLng.lng" :lat="latLng.lat" :lng="latLng.lng" @load="onMarkerLoaded"/>
            </naver-maps>
        </div>
        <div>
            <input type="text"
                   class="form-control w-75 mt-3"
                   placeholder="나머지 주소를 입력해주세요."
                   :value="data.address_detail"
                   @input="handleSetAddressDetail">
        </div>
    </article>
</template>

<script>
    import Vue from 'vue';
    import naver from 'vue-naver-maps';

    Vue.use(naver, {
        clientID: env.NAVER_CLOUD_ID,
        useGovAPI: false, //공공 클라우드 API 사용 (선택)
        subModules: 'geocoder' // 서브모듈 (선택)
    });

    export default {
        name: 'NaverMap',
        props: {
            data: Object
        },
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
                    lat: 37.487935,
                    lng: 126.857758
                },
                initLayers: ['BACKGROUND', 'BACKGROUND_DETAIL', 'POI_KOREAN', 'TRANSIT'],
                sido: '',
                gugun: '',
                dong: '',
                searchLists: [],
                showSearchList: false
            }
        },
        mounted() {
            this.latLng.lat = this.data.latitude;
            this.latLng.lng = this.data.longitude;
            this.sido = this.data.sido;
            this.gugun = this.data.gugun;
            this.dong = this.data.dong;
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
                const url = '/api/map/geocode';
                const responseSearch = axios.get(url, {
                    params: {
                        url: 'openapi.naver.com/v1/search/local',
                        query: this.data.address,
                        output: 'json'
                    }
                });
                const responseGeocode = axios.get(url, {
                    params: {
                        url: 'naveropenapi.apigw.ntruss.com/map-geocode/v2/geocode',
                        query: this.data.address,
                        coordType: 'latlng',
                        coord: 'latlng',
                        output: 'json',
                        count: 8
                    }
                });

                this.searchLists = [];
                this.showSearchList = false;
                axios.all([responseSearch, responseGeocode]).then(res => {
                    res.forEach(k => {
                        let items = [];

                        if (k.data.items) {
                            k.data.items.forEach(item => {
                                this.searchLists.push({
                                    address: item.roadAddress,
                                    latlng: {
                                        lat: item.mapx,
                                        lng: item.mapy
                                    },
                                    isKatek: true
                                });
                            })
                        } else if (k.data.addresses) {
                            k.data.addresses.forEach(item => {
                                this.searchLists.push({
                                    address: item.roadAddress,
                                    latlng: {
                                        lat: item.y,
                                        lng: item.x
                                    },
                                    isKatek: false
                                });
                            })
                        }
                    });

                    this.showSearchList = true;
                })
            },
            handleSetMap(data) {
                let latlng;

                if (data.isKatek) {
                    const position = window.naver.maps.TransCoord.fromTM128ToLatLng(window.naver.maps.Point(data.latlng.lat, data.latlng.lng));

                    latlng = {
                        lat: position.y,
                        lng: position.x
                    };
                } else {
                    latlng = {
                        lat: data.latlng.lat,
                        lng: data.latlng.lng
                    };
                }

                this.showSearchList = false;
                this.latLng.lat = latlng.lat;
                this.latLng.lng = latlng.lng;
                this.map.setCenter(latlng.lat, latlng.lng);

                this.handleSetAddress(data.address);

                axios.get('/api/map/reverse-geocode', {
                    params: {
                        latlng: `${latlng.lng},${latlng.lat}`
                    }
                }).then(res => {
                    const region = res.data.results[0].region;

                    this.sido = region.area1.name;
                    this.gugun = region.area2.name;
                    this.dong = region.area3.name;

                    this.handleSetProgram();
                })
            },
            handleSetAddress(e) {
                let address;

                if (e.target) {
                    address = e.target.value;
                } else {
                    address = e;
                }

                this.$emit('setAddress', address);
            },
            handleSetAddressDetail(e) {
                let addressDetail;

                if (e.target) {
                    addressDetail= e.target.value;
                } else {
                    addressDetail = e;
                }

                this.$emit('setAddressDetail', addressDetail);
            },
            handleSetProgram() {
                const data = {
                    latitude: this.latLng.lat,
                    longitude: this.latLng.lng,
                    sido: this.sido,
                    gugun: this.gugun,
                    dong: this.dong
                };

                this.$emit('setProgram', data);
            }
        }
    }
</script>

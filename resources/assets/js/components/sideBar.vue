<template>
  <div>
    <gmap-map
    :center="center"
    :zoom="7"
    style="width: 100%; height: 100%">
    <!-- 500 300 -->

    <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
        {{infoContent}}
    </gmap-info-window>

    <gmap-marker
      :key="index"
      v-for="(m, index) in markers"
      :position="m.position"
      :clickable="true"
      :visible="m.visible"
      @click="toggleInfoWindow(m,index)"
    ></gmap-marker>
  </gmap-map>

    <div class="row">
      <div class="col-sm-6 col-sm-offset-3">
        <div class="form-group">
          <label for="lng">Post Long</label>
          <input v-model="newPostLong" id="lng" type="text" class="form-control">
        </div>
        <div class="form-group">
          <label for="lat">Post Lat</label>
          <input v-model="newPostLat" id="lat" class="form-control"></input>
        </div>
        <div class="form-group">
          <label for="type">Type</label>
         <!--  <input v-model="newPostType" id="lng" type="text" class="form-control"> -->
          <select v-model="newPostType">
            <option disabled value="">Please select one</option>
            <option value="1">Food Service</option>
            <option value="2">Delivary Service</option>
            <option value="3">Computing Service</option>
            <option value="4">Other Service</option>
          </select>

        </div>
        <div class="form-group">
          <label for="desc">Desc</label>
          <textarea v-model="newPostDesc" id="description" class="form-control"></textarea>
        </div>
        <button @click="addMarker(newPostLong, newPostLat, newPostType, newPostDesc)" 
          :class="{disabled: (!newPostLong || !newPostLat || !newPostDesc)}"
          class="btn btn-block btn-primary">Submit</button>

        <!-- Button Bheckbox-->
        <div id="buttons">
          <input type="checkbox" value="1" v-model="filterOptions" id="foodService" class="chk-btn">
          <label for="foodService">Food Service</label>
          
          <input type="checkbox" value="2" v-model="filterOptions" id="delivaryService" class="chk-btn">
          <label for="delivaryService">Delivary Service</label>

          <input type="checkbox" value="3" v-model="filterOptions" id="computingService" class="chk-btn">
          <label for="computingService">Computing Service</label>

          <input type="checkbox" value="4" v-model="filterOptions" id="otherService" class="chk-btn">
          <label for="otherService">Other Service</label>
        </div>
      </div>
    </div>
  </div>
  
  <!-- <div class="marker-composer">
    <input type="text" placeholder="Type something here ..." v-model="markerText" @keyup.enter="sendMarker">
    <button class="btn btn-primary" @click="sendMarker">Send</button>
  </div> -->
</template>
 
<script>
  import * as VueGoogleMaps from 'vue2-google-maps';
  import Vue from 'vue';
 
  Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyAE4SKyeejyo2g7SnQy9DuGLiqOhyIo_1E',
      v: '3.29'
    }
  });
   
  export default {
    data () {
      return {
        newPostLong: '',
        newPostLat: '',
        newPostType: '',
        newPostDesc: '',
        markerText: '',
        center: {lat: 10.0, lng: 10.0},
        markers: [],
        positions: [],
        //Info window marker
        infoContent: '',
        infoWindowPos: {
          lat: 0,
          lng: 0
        },
        infoWinOpen: false,
        currentMidx: null,
        //optional: offset infowindow so it visually sits nicely on top of our marker
        infoOptions: {
          pixelOffset: {
            width: 0,
            height: -35
          }
        },
        //Checkbox filter
        filterOptions: []
      }
    },

    created() {
        axios.get('/markers').then(response => {
            // this.positions = response.data;
            for(var pos in response.data) {
              let rlat = response.data[pos].lat;
              let rlng = response.data[pos].lng;
              let rType = response.data[pos].type;
              let rDesc = response.data[pos].description;

              this.markers.push({
                position: { lat: rlat, lng: rlng },
                markerType: rType,
                infoText: rDesc
              })
            }
            // console.log(response.data[0].lat);
            // this.markers.push({
            //   position
            // })
          
            // console.log(this.markers.markerType);

            Echo.channel('markers')
            .listen('.MarkersUpdate', mark => {
                this.markers.push({
                    position: {
                      lat: mark.lat,
                      lng: mark.lng
                    },
                    infoText: mark.description,
                    markerType: mark.type
                })
            });
        })
    },

    watch: {
      filterOptions() {
        var _this = this;
        var filterMarkList = this.filterOptions;
        var i;
        var opt;
        var marker;
        var keep;

        //Filter
        
        for(i=0; i<_this.markers.length; i++) {
          marker = _this.markers[i];
          // console.log(_this.markers[1].markerType);
          keep = true;
          for(opt=0; opt<filterMarkList.length; opt++) {
            // console.log(filterMarkList[1]);
            if(marker.markerType != filterMarkList[opt]) {
              keep = false;
            }
          }
          marker.visible = keep;
        }
      }
    },

    methods: {
      addMarker(postLong, postLat, postType, postDesc) {
        let plng = parseFloat(postLong);
        let plat = parseFloat(postLat);
        let ptype = postType;
        let pdesc = postDesc;

        this.markers.push({
          position: { 
            lat: plat,
            lng: plng
          },
          infoText: pdesc,
          markerType: ptype
        })

        axios.post('/postMarker', {
          lng: plng, lat: plat, type: ptype, description: pdesc
        }).then(response => {
          if(response.data) {
            this.newPostLong = this.newPostLat = this.newPostDesc = "";
          }
        })
      },

      toggleInfoWindow: function(marker, idx) {
        this.infoWindowPos = marker.position;
        this.infoContent = marker.infoText;

        if (this.currentMidx == idx) {
          this.infoWinOpen = !this.infoWinOpen;
        } else {
          this.infoWinOpen = true;
          this.currentMidx = idx;
        }
      },

      // filterMarkers: function() {
      //   let set_filters = filterOptions();
      //   console.log('see');
      //   for(var i=0; i<markers.length; i++) {
      //     var marker = markers[i];

      //     var keep = true;
      //     for(var opt=0; opt<set_filters.length; opt++) {
      //       if(!marker.markerType[set_filters[opt]]) {
      //         keep = false;
      //       }
      //     }
      //     marker.visible = keep;
      //   }
      // }
    }, 
  }
</script>
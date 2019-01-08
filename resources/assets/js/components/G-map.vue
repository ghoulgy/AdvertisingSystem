<template>
  <div>
    <div class="col-md-2">
      <div class="panel panel-default">
        <div class="panel-heading"> 
          <h2>Filter</h2>
          <div class="container-fluid">
            <div id="buttons">
              <div class="row">
                <input type="checkbox" value="1" v-model="filterOptions" id="foodService" class="chk-btn">
                <label for="foodService" style="width: 100%">Food Service</label>
              </div>

              <div class="row">
                <input type="checkbox" value="2" v-model="filterOptions" id="delivaryService" class="chk-btn">
                <label for="delivaryService" style="width: 100%">Delivary Service</label>  
              </div>
              
              <div class="row">
                <input type="checkbox" value="3" v-model="filterOptions" id="computingService" class="chk-btn">
                <label for="computingService" style="width: 100%">Computing Service</label>
              </div>
              <div class="row">
                <input type="checkbox" value="4" v-model="filterOptions" id="otherService" class="chk-btn">
                <label for="otherService" style="width: 100%">Other Service</label>
              </div>
            </div>    
          </div>
        </div>
      </div>
      <!-- <ul class="">
        <li class="active"><a href="#">Home<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-home"></span></a></li>
        <li ><a href="#">Profile<span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-user"></span></a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Settings <span class="caret"></span><span style="font-size:16px;" class="pull-right hidden-xs showopacity glyphicon glyphicon-cog"></span></a>
            <ul class="dropdown-menu forAnimate" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
                <li class="divider"></li>
                <li><a href="#">One more separated link</a></li>
            </ul>
        </li>
      </ul> -->
      <!-- Button Bheckbox-->
      
    </div>
    <div class="col-md-7">
      <gmap-map
      :center="center"
      :zoom="7"
      style="width:100%; height:600px">

        <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
            <div>
              <h2>{{ infoTitle }}</h2>
              <h3>{{ infoContent }}</h3>
              <div class="container-fluid">
                <div class="pull-left">
                  <button @click="lookProfile()"
                    class="btn btn-block btn-primary">Profile</button>
                </div>
                <div class="pull-right">
                  <button @click="request()" 
                    class="btn btn-block btn-primary">{{ selfUserId }}Request</button>
                </div>
              </div>
            </div>
        </gmap-info-window>

        <gmap-marker
          :key="index"
          v-for="(m, index) in markers"
          :position="m.position"
          :clickable="true"
          :visible="m.visible"
          @click="toggleInfoWindow(m,index)"
        ></gmap-marker>

        <gmap-marker
          :key="index"
          v-for="(m, index) in markersDemand"
          :position="m.position"
          :clickable="true"
          :visible="m.visible"
          @click="toggleInfoWindow(m,index)"
          :label="m.label"
        ></gmap-marker>
      </gmap-map>
      
      <div class="container" style="margin-top: 2%">
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-login">
              <div class="panel-heading">
                <div class="row">
                  <div class="col-xs-6">
                    <a class="active" id="service-provider-link">Post Service</a>
                  </div>
                  <div class="col-xs-6">
                    <a id="demand-form-link">Post Demand</a>
                  </div>
                </div>
                <hr>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-lg-12">
                    <div id="service-provider-form" style="display: block">
                      <div class="form-group">
                        <label for="lng">Post Long</label>
                        <input v-model="newPostLong" id="lng" class="form-control">
                      </div>

                      <div class="form-group">
                        <label for="lat">Post Lat</label>
                        <input v-model="newPostLat" id="lat" class="form-control"></input>
                      </div>

                      <div class="form-group">
                        <label for="title">Post Title</label>
                        <input v-model="newPostTitle" id="title" class="form-control"></input>
                      </div>

                      <div class="form-group">
                        <label for="type">Type</label>
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

                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-6 col-sm-offset-3">
                              <button @click="addMarker(newPostLong, newPostLat, newPostTitle, newPostType, newPostDesc)" 
                                :class="{disabled: (!newPostLong || !newPostLat || !newPostDesc)}"
                                class="btn btn-block btn-primary">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="demand-form" style="display: none">
                      <div class="form-group">
                        <label for="lng">Post Long</label>
                        <input v-model="newDemandPostLong" id="lng" class="form-control">
                      </div>
                      
                      <div class="form-group">
                        <label for="lat">Post Lat</label>
                        <input v-model="newDemandPostLat" id="lat" class="form-control"></input>
                      </div>

                      <div class="form-group">
                        <label for="demandTitle">Demand Title</label>
                        <input v-model="newDemandTitle" id="demandTitle" class="form-control"></input>
                      </div>
                      
                      <div class="form-group">
                        <label for="demandType">Demand Type</label>
                        <select v-model="newDemandType">
                          <option disabled value="">Please select one</option>
                          <option value="1">Food Service</option>
                          <option value="2">Delivary Service</option>
                          <option value="3">Computing Service</option>
                          <option value="4">Other Service</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="demandNeeds">Demand Needs</label>
                        <select v-model="newDemandNeeds">
                          <option disabled value="">Please select one</option>
                          <option value="1">Normal</option>
                          <option value="2">Urgent</option>
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="demand">Demand Description:</label>
                        <textarea v-model="newDemandDesc" id="demandDesc" class="form-control"></textarea>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-6 col-sm-offset-3">
                            <button @click="addDemandMarker(newDemandPostLong, newDemandPostLat, newDemandTitle, 
                              newDemandType, newDemandNeeds, newDemandDesc)" 
                              :class="{disabled: (!newDemandPostLong || !newDemandPostLat || !newDemandTitle)}"
                              class="btn btn-block btn-primary">Submit</button> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
        selectedUserId: '',
        selfUserId: '',
        newPostLong: '',
        newPostLat: '',
        newPostType: '',
        newPostDesc: '',
        newPostTitle: '',
        markerText: '',
        newDemandPostLat: '',
        newDemandPostLong: '', 
        newDemandTitle: '',
        newDemandType: '',
        newDemandNeeds: '',
        newDemandDesc: '',
        center: {lat: 10.0, lng: 10.0},
        markersDemand: [],
        markers: [],
        positions: [],
        //Info window marker
        infoTitle: '',
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
        axios.get('/user').then(response => {
            this.selectedUserId = response.data;
            // console.log(this.selectedUserId)
            Echo.private('Api.User.' + this.selectedUserId)
              .listen('RequestCreatePrivate', (e) => {
                console.log("lol");
              });
        }),

        // axios.get('/api/self').then(response => {
        //   this.me = response.body

        //   Echo.private('Api.User.' + this.me.id)
        //       .listen('MessageCreatePrivateEvent', (e) => {
        //         console.log("lol");
        //       });
        // }),

        axios.get('/markers').then(response => {
            // this.positions = response.data;
            for(var pos in response.data) {
              let rlat = response.data[pos].lat;
              let rlng = response.data[pos].lng;
              let rType = response.data[pos].type;
              let rDesc = response.data[pos].description;
              let rTitle = response.data[pos].title;
              let rId = response.data[pos].user_id;

              this.markers.push({
                position: { lat: rlat, lng: rlng },
                title: rTitle,
                markerType: rType,
                infoText: rDesc,
                currentUserId: rId
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
                  title: mark.title,
                  markerType: mark.type,
                  infoText: mark.description,
                  currentUserId: mark.user_id
              })
            });
        }),

        axios.get('/markersDemand').then(response => {
            // this.positions = response.data;
            for(var pos in response.data) {
              let rlat = response.data[pos].lat;
              let rlng = response.data[pos].lng;
              let rTitle = response.data[pos].title;
              let rType = response.data[pos].type;
              let rNeed = response.data[pos].need;
              let rDesc = response.data[pos].description;
              let rId = response.data[pos].user_id;

              this.markers.push({
                position: { lat: rlat, lng: rlng },
                title: rTitle,
                label: "D",
                demandType: rType,
                demandNeeds: rNeed,
                infoText: rDesc,
                currentUserId: rId
              })
            }
            // console.log(response.data[0].lat);
            // this.markers.push({
            //   position
            // })
          
            // console.log(this.markers.markerType);

            Echo.channel('markersDemand')
            .listen('.MarkersDemandUpdate', markDemand => {
                this.markersDemand.push({
                    position: {
                      lat: markDemand.lat,
                      lng: markDemand.lng
                    },
                    title: markDemand.title,
                    label: "D",
                    demandNeeds: markDemand.need,
                    demandType: markDemand.type,
                    infoText: markDemand.description,
                    currentUserId: markerDemand.user_id
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
      addMarker(postLong, postLat, postTitle, postType, postDesc) {
        let plng = parseFloat(postLong);
        let plat = parseFloat(postLat);
        let ptitle = postTitle;
        let ptype = postType;
        let pdesc = postDesc;

        this.markers.push({
          position: { 
            lat: plat,
            lng: plng
          },
          title: ptitle,
          infoText: pdesc,
          markerType: ptype,
          currentUserId: this.selectedUserId
        })

        axios.post('/postMarker', {
          lng: plng, lat: plat, title: ptitle, type: ptype, description: pdesc
        }).then(response => {
          if(response.data) {
            this.newPostLong = this.newPostLat = this.newPostDesc = "";
          }
        })
      },

      addDemandMarker(postLong, postLat, postTitle, postType, postNeed, postDesc) {
        let plng = parseFloat(postLong);
        let plat = parseFloat(postLat);
        let ptitle = postTitle;
        let ptype = postType;
        let pneed = postNeed;
        let pdesc = postDesc;

        this.markersDemand.push({
          position: { 
            lat: plat,
            lng: plng
          },
          title: ptitle,
          label: "D",
          infoText: pdesc,
          demandType: ptype,
          demandNeeds: pneed,
          currentUserId: this.selectedUserId
        })

        axios.post('/postDemandMarker', {
          lng: plng, lat: plat, title: ptitle, type: ptype, need: pneed, description: pdesc
        }).then(response => {
          if(response.data) {
            this.newDemandTitle = this.newDemandPostLong = this.newDemandPostLat = this.newDemandDesc = "";
          }
        })
      },

      request() {
        // console.log(this.selectedUserId);
        // axios.post('/test').then(response => {

        // })
        axios.post('/api/requests/to/' + this.selfUserId).then(response => {
            console.log('R sents');
        })
      },

      toggleInfoWindow: function(marker, idx) {
        this.infoWindowPos = marker.position;
        this.infoTitle = marker.title;
        this.infoContent = marker.infoText;
        this.selfUserId = marker.currentUserId;

        if (this.currentMidx == idx) {
          this.infoWinOpen = !this.infoWinOpen;
        } else {
          this.infoWinOpen = true;
          this.currentMidx = idx;
        }
      },
    }, 
  }
</script>
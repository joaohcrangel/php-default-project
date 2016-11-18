import Site from 'Site';

class Map {
  constructor() {
    this.window = $(window);
    this.$siteNavbar = $('.site-navbar');
    this.$siteFooter = $('.site-footer');
    this.$pageMain = $('.page-main');

    this.handleMapHeight();
  }

  handleMapHeight() {
    let footerH = this.$siteFooter.outerHeight(),
      navbarH = this.$siteNavbar.outerHeight();
    let mapH = this.window.height() - navbarH - footerH;

    this.$pageMain.outerHeight(mapH);
  }

  getMap() {
    let mapLatlng = L.latLng(37.769, -122.446);

    // this accessToken, you can get it to here ==> [ https://www.mapbox.com ]
    L.mapbox.accessToken = 'pk.eyJ1IjoiYW1hemluZ3N1cmdlIiwiYSI6ImNpaDVubzBoOTAxZG11dGx4OW5hODl2b3YifQ.qudwERFDdMJhFA-B2uO6Rg';

    return L.mapbox.map('map', 'mapbox.light').setView(mapLatlng, 18);
  }
}

class Markers {
  constructor(friends, map) {
    this.friends = friends;
    this.map = map;
    this.allMarkers = [];

    this.handleMarkers();
  }

  handleMarkers() {
    /* add markercluster Plugin */
    // this mapbox's Plugins,you can get it to here ==> [ https://github.com/Leaflet/Leaflet.markercluster.git ]
    let markers = new L.MarkerClusterGroup({
      removeOutsideVisibleBounds: false,
      polygonOptions: {
        color: '#444'
      }
    });

    for (let i = 0; i < this.friends.length; i++) {
      let path, x;

      if (i % 2 === 0) {
        x = Number(Math.random());
      } else {
        x = -1 * Math.random();
      }

      let markerLatlng = L.latLng(37.769 + Math.random() / 170 * x, -122.446 + Math.random() / 150 * x);

      path = $(this.friends[i]).find('img').attr('src');

      let divContent = '<div class=\'in-map-markers\'><div class=\'friend-icon\'><img src=\'' + path + '\' /></div></div>';

      let friendImg = L.divIcon({
        html: divContent,
        iconAnchor: [0, 0],
        className: ''
      });

      /* create new marker and add to map */
      let popupInfo = '<div class=\'friend-popup-info\'><div class=\'detail\'>info</div><h3>' + $(this.friends[i]).find('.friend-name').html() + '</h3><p>' + $(this.friends[i]).find('.friend-title').html() + '</p></div><i class=\'icon md-chevron-right\'></i>';
      let marker = L.marker(markerLatlng, {
        title: $(this.friends[i]).find('friend-name').html(),
        icon: friendImg
      }).bindPopup(popupInfo, {
        closeButton: false
      });

      markers.addLayer(marker);

      this.allMarkers.push(marker);

      marker.on('popupopen', function() {
        this._icon.className += ' marker-active';
        this.setZIndexOffset(999);
      });

      marker.on('popupclose', function() {
        if (this._icon) {
          this._icon.className = 'leaflet-marker-icon leaflet-zoom-animated leaflet-clickable';
        }
        this.setZIndexOffset(450);
      });
    }

    this.map.addLayer(markers);
  }

  getAllMarkers() {
    return this.allMarkers;
  }

  getMarkersInMap() {
    let inMapMarkers = [];
    let allMarkers = this.getAllMarkers();

    /* Get the object of all Markers in the map view */
    for (let i = 0; i < allMarkers.length; i++) {
      if (this.map.getBounds().contains(allMarkers[i].getLatLng())) {
        inMapMarkers.push(allMarkers.indexOf(allMarkers[i]));
      }
    }

    return inMapMarkers;
  }
}

class AppLocation extends Site {
  processed() {
    super.processed();

    this.window = $(window);
    this.$listItem = $('.app-location .page-aside .list-group');
    this.$allFriends = $('.app-location .friend-info');
    this.allFriends = this.getAllFriends();
    this.mapbox = new Map();

    this.map = this.mapbox.getMap();
    this.markers = new Markers(this.$allFriends, this.map);
    this.allMarkers = this.markers.getAllMarkers();

    this.markersInMap = null;
    this.friendNum = null;

    this.handleResize();
    this.steupListItem();
    this.steupMapChange();
    this.handleSearch();
  }

  getDefaultState() {
    return Object.assign(super.getDefaultState(), {
      mapChange: true,
      listItemActive: false
    });
  }

  getDefaultActions() {
    return Object.assign(super.getDefaultActions(), {
      mapChange(change) {

        if (change) {
          console.log('map change');
        } else {
          let friendsInList = [];

          this.markersInMap = this.markers.getMarkersInMap();
          for (let i = 0; i < this.allMarkers.length; i++) {
            if (this.markersInMap.indexOf(i) === -1) {
              $(this.allFriends[i]).hide();
            } else {
              $(this.allFriends[i]).show();
              friendsInList.push($(this.allFriends[i]));
            }
          }

          this.friendsInList = friendsInList;
        }
      },
      listItemActive(active) {
        if (active) {
          this.map.panTo(this.allMarkers[this.friendNum].getLatLng());
          this.allMarkers[this.friendNum].openPopup();
        } else {
          console.log('listItem unactive');
        }
      }
    });
  }

  getAllFriends() {
    let allFriends = [];

    this.$allFriends.each(function() {
      allFriends.push(this);
    });

    return allFriends;
  }

  steupListItem() {
    let self = this;

    this.$allFriends.on('click', function() {

      $('.list-inline').on('click', (event) => {
        event.stopPropagation();
      });

      self.friendNum = self.allFriends.indexOf(this);

      self.setState('listItemActive', true);
    });

    this.$allFriends.on('mouseup', () => {
      this.setState('listItemActive', false);
    });
  }

  steupMapChange() {
    this.map.on('viewreset move', () => {
      this.setState('mapChange', true);
    });

    this.map.on('ready blur moveend dragend zoomend', () => {
      this.setState('mapChange', false);
    });
  }

  handleResize() {
    this.window.on('resize', () => {
      this.mapbox.handleMapHeight();
    });
  }

  handleSearch() {
    let self = this;
    $('.search-friends input').on('focus', function() {
      $(this).on('keyup', () => {
        let inputName = $('.search-friends input').val();

        for (let i = 0; i < self.friendsInList.length; i++) {
          let friendName = self.friendsInList[i].find('.friend-name').html();

          if (inputName.length <= friendName.length) {
            for (let j = 1; j <= inputName.length; j++) {
              if (inputName.substring(0, j).toLowerCase() === friendName.substring(0, j).toLowerCase()) {
                self.friendsInList[i].show();
              } else {
                self.friendsInList[i].hide();
              }
            }
          } else {
            self.friendsInList[i].hide();
          }
        }
        if (inputName === '') {
          for (let i = 0; i < self.friendsInList.length; i++) {
            self.friendsInList[i].show();
          }
        }
      });
    });
    $('.search-friends input').on('focusout', function() {
      $(this).off('keyup');
    });
  }
}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppLocation();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppLocation;
export {
  AppLocation,
  run,
  getInstance
};

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
  constructor(spots, hotels, reviews, map) {
    this.spots = spots;
    this.hotels = hotels;
    this.reviews = reviews;
    this.map = map;
    this.markers = null;
    this.allMarkers = [];

    this.addMarkersByOption('spots');
  }

  deleteMarkers() {
    this.map.removeLayer(this.markers);
    this.markers = null;
    this.allMarkers.length = 0;
  }

  addMarkersByOption(option) {
    /* add markercluster Plugin */
    // this mapbox's Plugins,you can get it to here ==> [ https://github.com/Leaflet/Leaflet.markercluster.git ]
    this.markers = new L.MarkerClusterGroup({
      removeOutsideVisibleBounds: false,
      polygonOptions: {
        color: '#444'
      }
    });
    this.initMarkers(this.markers, this[`${option}`]);
    this.map.addLayer(this.markers);
  }

  initMarkers(markers, items) {
    for (let i = 0; i < items.length; i++) {
      let path, x;

      if (i % 2 === 0) {
        x = Number(Math.random());
      } else {
        x = -1 * Math.random();
      }

      let markerLatlng = L.latLng(37.769 + Math.random() / 170 * x, -122.446 + Math.random() / 150 * x);

      path = $(items[i]).find('img').attr('src');

      let divContent = `<div class='in-map-markers'>
                          <div class='marker-icon'>
                            <img src='${path}'/>
                          </div>
                        </div>`;

      let itemImg = L.divIcon({
        html: divContent,
        iconAnchor: [0, 0],
        className: ''
      });

      /* create new marker and add to map */
      let itemName = $(items[i]).find('.item-name').html();
      let itemTitle = $(items[i]).find('.item-title').html();
      let popupInfo = `<div class='marker-popup-info'>
                        <div class='detail'>info</div>
                        <h3>${itemName}</h3>
                        <p>${itemTitle}</p>
                      </div>
                      <i class='icon wb-chevron-right-mini'>
                      </i>`;
      let marker = L.marker(markerLatlng, {
        title: itemName,
        icon: itemImg
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

class AppTravel extends Site {
  processed() {
    super.processed();

    this.window = $(window);
    this.$pageAside = $('.page-aside');

    this.$allSpots = $('.app-travel .spot-info');
    this.allSpots = this.getAllListItems(this.$allSpots);
    this.$allHotels = $('.app-travel .hotel-info');
    this.allHotels = this.getAllListItems(this.$allHotels);
    this.$allReviews = $('.app-travel .review-info');
    this.allReviews = this.getAllListItems(this.$allReviews);

    this.mapbox = new Map();
    this.map = this.mapbox.getMap();

    this.markers = new Markers(this.$allSpots, this.$allHotels, this.$allReviews, this.map);
    this.allMarkers = this.markers.getAllMarkers();

    this.markersInMap = null;
    this.spotsNum = null;
    this.hotelsNum = null;
    this.reviewsNum = null;

    this.handleResize();

    this.steupListItem('spots');
    this.steupListItem('hotels');
    this.steupListItem('reviews');

    this.steupMapChange();
    this.setupTabChange();
    this.handleSwitchClick();
    this.handleSpotAction();
  }

  getAllListItems($allListItems) {
    let allListItems = [];
    $allListItems.each(function() {
      allListItems.push(this);
    });

    return allListItems;
  }

  getDefaultState() {
    return Object.assign(super.getDefaultState(), {
      mapChange: true,
      listItemActive: false,
      optionChange: 'spots'
    });
  }

  getDefaultActions() {
    let self = this;
    return Object.assign(super.getDefaultActions(), {
      optionChange(change) {
        if (change) {
          console.log('tab change');
          if (self.markers.markers) {
            self.markers.deleteMarkers();
          }
          let tabOption = self.getState('optionChange'); // spots,hotels,reviews
          self.markers.addMarkersByOption(tabOption);
          self.changeListItemsByOption(tabOption);
        }
      },
      mapChange(change) {
        if (change) {
          console.log('map change');
        } else {
          let tabOption = self.getState('optionChange');
          self.changeListItemsByOption(tabOption);
        }
      },
      listItemActive(active) {
        if (active) {
          let tabOption = self.getState('optionChange');
          this.changeMapOnListActiveByOption(tabOption);
        } else {
          console.log('listItem unactive');
        }
      }
    });
  }

  // change list when map change
  changeListItems(allListItems) {
    let itemsInList = [];
    this.markersInMap = this.markers.getMarkersInMap();
    for (let i = 0; i < this.allMarkers.length; i++) {
      if (this.markersInMap.indexOf(i) === -1) {
        $(allListItems[i]).hide();
      } else {
        $(allListItems[i]).show();
        itemsInList.push($(allListItems[i]));
      }
    }
    return itemsInList;
  }

  onSpotsListChange(spotsItemsInList) {
    $('.clearfix.hidden-xl-down').remove();
    for (let i = 0; i < spotsItemsInList.length; i++) {
      if (i > 0 && (i + 1) % 2 === 0) {
        let $clear = $('<div></div>').addClass('clearfix hidden-xl-down');
        spotsItemsInList[i].after($clear);
      }
    }
  }

  onReviewsListChange(reviewsItemsInList) {
    let $lastReview = $('.last-review');
    if ($lastReview.length > 0) {
      $lastReview.removeClass('last-review');
    }
    let length = reviewsItemsInList.length;
    if (length > 0) {
      reviewsItemsInList[length - 1].addClass('last-review');
    }
  }

  changeListItemsByOption(option) {
      let optionString = option.substring(0, 1).toUpperCase() + option.substring(1);

      let itemsInList = this.changeListItems(this[`all${optionString}`]);
      this[`on${optionString}ListChange`] ? this[`on${optionString}ListChange`](itemsInList) : '';

      this.window.trigger('resize');
    }
    // end change list when map change

  // change map on list change
  changeMapOnListActive(num) {
    this.map.panTo(this.allMarkers[num].getLatLng());
    this.allMarkers[num].openPopup();
  }

  changeMapOnListActiveByOption(option) {
      this.changeMapOnListActive(this[`${option}Num`]);
    }
    // end change map on list change

  // bind
  steupListItem(option) {
    let self = this;
    let optionString = option.substring(0, 1).toUpperCase() + option.substring(1);

    this[`$all${optionString}`].on('click', function() {
      $('.rating').on('click', (event) => {
        event.stopPropagation();
      });

      self[`${option}Num`] = self[`all${optionString}`].indexOf(this);
      self.setState('listItemActive', true);
    });

    this[`$all${optionString}`].on('mouseup', () => {
      this.setState('listItemActive', false);

    });
  }

  setupTabChange() {
    let self = this;
    $('a[data-toggle="tab"]').on('shown.bs.tab', (e) => {
      e.target; // newly activated tab
      let href = $(this).attr('href'); // #spots,#travels,#reviews
      let option = href.substring(1);
      self.setState('optionChange', `${option}`);
      e.relatedTarget; // previous active tab
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

  handleSwitchClick() {
    let self = this;
    $(document).on('click', '.page-aside .page-aside-switch', (event) => {
      if (self.$pageAside.hasClass('open')) {
        let tabOption = self.getState('optionChange');
        self.changeListItemsByOption(tabOption);
      } else {
        event.stopPropagation();
      }
    });
  }

  handleResize() {
    this.window.on('resize', () => {
      this.mapbox.handleMapHeight();
    });
  }

  handleSpotAction() {
      $(document).on('click', '.card-actions', function() {
        let $this = $(this);
        $this.toggleClass('active');
      });
    }
    // end bind
}

let instance = null;

function getInstance() {
  if (!instance) {
    instance = new AppTravel();
  }
  return instance;
}

function run() {
  let app = getInstance();
  app.run();
}

export default AppTravel;
export {
  AppTravel,
  run,
  getInstance
};

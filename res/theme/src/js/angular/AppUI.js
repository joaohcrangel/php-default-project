(function(window, document, $, angular) {
  'use strict';

  var AppUI = angular.module('AppUI', ['ui.router', 'oc.lazyLoad', 'ui.bootstrap']);

  AppUI.config(["$stateProvider", "$urlRouterProvider", "$ocLazyLoadProvider", function($stateProvider, $urlRouterProvider, $ocLazyLoadProvider) {

    $stateProvider.state("angularui", {
      url: "/angularui/:type",
      controller: "AngularUIController",
      templateUrl: function($stateParams) {
        return "templates/ui/" + $stateParams.type + ".html";
      },
      resolve: {
        resoucre: function($http, $stateParams) {
          return $http.get("../../assets/data/angular/ui/" + $stateParams.type + ".json").success(function() {
            NProgress.done();
          });
        }
      }
    });
  }]);

  AppUI.controller('AsideController', ['$rootScope', '$scope', '$http', '$location', '$window', function($rootScope, $scope, $http, $location, $window) {
    $scope.lists = [];
    $http.get('../../assets/data/angular/aside.json').success(function(data) {
      $scope.lists = data;
      var tag = '',
        url = $location.url(),
        flag = true;
      for (var i = 0; i < $scope.lists.length; i++) {
        tag = $scope.lists[i].url;
        if (flag && url.search(tag) > 0) {
          $scope.lists[i].active = 'active';
          flag = false;
        } else {
          $scope.lists[i].active = '';
        }
      };
    });

    $rootScope.$on('$locationChangeStart', function(e, url) {
      var tag = '',
        flag = true;
      for (var i = 0; i < $scope.lists.length; i++) {
        tag = $scope.lists[i].url;

        if (flag && url.search(tag) > 0) {
          $scope.lists[i].active = 'active';
          flag = false;
        } else {
          $scope.lists[i].active = '';
        }
      };
      NProgress.start();
    });



  }]).controller('AngularUIController', ['$scope', 'resoucre', function($scope, resoucre) {
    $scope.model = resoucre.data;
  }]).controller('AlertDemoController', ['$scope', function($scope) {
    $scope.alerts = $scope.model;
    $scope.addAlert = function() {
      $scope.model.push({
        msg: 'Another alert!'
      });
    };

    $scope.closeAlert = function(index) {
      $scope.model.splice(index, 1);
    };
  }]).controller('ButtonsDemoController', ['$scope', function($scope) {
    $scope.singleModel = $scope.model.singleModel;
    $scope.radioModel = $scope.model.radioModel;
    $scope.checkModel = $scope.model.checkModel;
  }]).controller('ButtonsDemoController', ['$scope', function($scope) {
    $scope.singleModel = $scope.model.singleModel;
    $scope.radioModel = $scope.model.radioModel;
    $scope.checkModel = $scope.model.checkModel;
  }]).controller('CarouselDemoController', ['$scope', function($scope) {
    $scope.myInterval = $scope.model.myInterval;
    var slides = $scope.slides = [];
    $scope.addSlide = function() {
      var newWidth = 600 + slides.length + 1;
      slides.push({
        image: 'http://placekitten.com/' + newWidth + '/300',
        text: ['More', 'Extra', 'Lots of', 'Surplus'][slides.length % 4] + ' ' + ['Cats', 'Kittys', 'Felines', 'Cutes'][slides.length % 4]
      });
    };
    for (var i = 0; i < 4; i++) {
      $scope.addSlide();
    }
  }]).controller('CollapseDemoController', ['$scope', function($scope) {
    $scope.isCollapsed = $scope.model.isCollapsed;
  }]).controller('DatepickerDemoController', ['$scope', function($scope) {
    $scope.today = function() {
      $scope.dt = new Date();
    };
    $scope.today();

    $scope.clear = function() {
      $scope.dt = null;
    };

    // Disable weekend selection
    $scope.disabled = function(date, mode) {
      return (mode === 'day' && (date.getDay() === 0 || date.getDay() === 6));
    };

    $scope.toggleMin = function() {
      $scope.minDate = $scope.minDate ? null : new Date();
    };
    $scope.toggleMin();

    $scope.open = function($event) {
      $event.preventDefault();
      $event.stopPropagation();

      $scope.opened = true;
    };

    $scope.dateOptions = {
      formatYear: 'yy',
      startingDay: 1
    };

    $scope.formats = $scope.model.formats;
    $scope.format = $scope.formats[0];
  }]).controller('DropdownDemoController', ['$scope', '$log', function($scope, $log) {
    $scope.toggled = function(open) {
      $log.log('Dropdown is now: ', open);
    };

    $scope.toggleDropdown = function($event) {
      $event.preventDefault();
      $event.stopPropagation();
      $scope.status.isopen = !$scope.status.isopen;
    };
  }]).controller('ModalDemoController', ['$scope', '$modal', '$log', function($scope, $modal, $log) {

    $scope.items = $scope.model.items;
    $scope.animationsEnabled = true;
    $scope.open = function(size) {

      var modalInstance = $modal.open({
        animation: $scope.animationsEnabled,
        templateUrl: 'myModalContent.html',
        controller: 'ModalInstanceController',
        size: size,
        resolve: {
          items: function() {
            return $scope.items;
          }
        }
      });

      modalInstance.result.then(function(selectedItem) {
        $scope.selected = selectedItem;
      }, function() {
        $log.info('Modal dismissed at: ' + new Date());
      });

      $scope.toggleAnimation = function() {
        $scope.animationsEnabled = !$scope.animationsEnabled;
      };
    };

  }]).controller('ModalInstanceController', ['$scope', '$modalInstance', 'items', function($scope, $modalInstance, items) {
    // Please note that $modalInstance represents a modal window (instance) dependency.
    // It is not the same as the $modal service used above.
    $scope.items = items;
    $scope.selected = {
      item: $scope.items[0]
    };

    $scope.ok = function() {
      $modalInstance.close($scope.selected.item);
    };

    $scope.cancel = function() {
      $modalInstance.dismiss('cancel');
    };
  }]).controller('PaginationDemoController', ['$scope', '$log', function($scope, $log) {
    $scope.totalItems = $scope.model.totalItems;
    $scope.currentPage = $scope.model.currentPage;
    $scope.maxSize = $scope.model.maxSize;
    $scope.bigTotalItems = $scope.model.bigTotalItems;
    $scope.bigCurrentPage = $scope.model.bigCurrentPage;

    $scope.setPage = function(pageNo) {
      $scope.currentPage = pageNo;
    };

    $scope.pageChanged = function() {
      $log.log('Page changed to: ' + $scope.currentPage);
    };
  }]).controller('PopoverDemoController', ['$scope', function($scope) {
    $scope.dynamicPopover = $scope.model.dynamicPopover;
    $scope.dynamicPopoverTitle = $scope.model.dynamicPopoverTitle;
  }]).controller('ProgressbarDemoController', ['$scope', function($scope) {

    $scope.max = $scope.model.max;

    $scope.random = function() {
      var value = Math.floor((Math.random() * 100) + 1);
      var type;

      if (value < 25) {
        type = 'success';
      } else if (value < 50) {
        type = 'info';
      } else if (value < 75) {
        type = 'warning';
      } else {
        type = 'danger';
      }

      $scope.showWarning = (type === 'danger' || type === 'warning');

      $scope.dynamic = value;
      $scope.type = type;
    };
    $scope.random();

    $scope.randomStacked = function() {
      $scope.stacked = [];
      var types = ['success', 'info', 'warning', 'danger'];

      for (var i = 0, n = Math.floor((Math.random() * 4) + 1); i < n; i++) {
        var index = Math.floor((Math.random() * 4));
        $scope.stacked.push({
          value: Math.floor((Math.random() * 30) + 1),
          type: types[index]
        });
      }
    };
    $scope.randomStacked();
  }]).controller('RatingDemoController', function($scope) {
    $scope.rate = $scope.model.rate;
    $scope.max = $scope.model.max;
    $scope.isReadonly = $scope.model.isReadonly;
    $scope.ratingStates = $scope.model.ratingStates;

    $scope.hoveringOver = function(value) {
      $scope.overStar = value;
      $scope.percent = 100 * (value / $scope.max);
    };
  }).controller('TabsDemoController', ['$scope', '$window', function($scope, $window) {
    $scope.tabs = $scope.model;

    $scope.alertMe = function() {
      setTimeout(function() {
        $window.alert('You\'ve selected the alert tab!');
      });
    };
  }]).controller('TimepickerDemoController', ['$scope', '$log', function($scope, $log) {
    $scope.mytime = new Date();

    $scope.hstep = $scope.model.hstep;
    $scope.mstep = $scope.model.mstep;
    $scope.options = $scope.model.options;
    $scope.ismeridian = $scope.model.ismeridian;

    $scope.toggleMode = function() {
      $scope.ismeridian = !$scope.ismeridian;
    };

    $scope.update = function() {
      var d = new Date();
      d.setHours(14);
      d.setMinutes(0);
      $scope.mytime = d;
    };

    $scope.changed = function() {
      $log.log('Time changed to: ' + $scope.mytime);
    };

    $scope.clear = function() {
      $scope.mytime = null;
    };
  }]).controller('TooltipDemoController', ['$scope', function($scope) {
    $scope.dynamicTooltip = $scope.model.dynamicTooltip;
    $scope.dynamicTooltipText = $scope.model.dynamicTooltipText;
    $scope.htmlTooltip = $scope.model.htmlTooltip;
  }]).controller('TypeaheadDemoController', ['$scope', function($scope) {
    $scope.states = $scope.model.states;
    $scope.statesWithFlags = $scope.model.statesWithFlags;
    $scope.selected = undefined;
    // Any function returning a promise object can be used to load values asynchronously
    $scope.getLocation = function(val) {
      return $http.get('http://maps.googleapis.com/maps/api/geocode/json', {
        params: {
          address: val,
          sensor: false
        }
      }).then(function(response) {
        return response.data.results.map(function(item) {
          return item.formatted_address;
        });
      });
    };

  }]);

})(window, document, jQuery, angular);

(function(window, document, $, angular) {
  'use strict';

  var AngularApp = angular.module('AngularApp', ['ngSanitize', 'ui.router', "oc.lazyLoad"]);

  AngularApp.controller('AngularUIController', ['$scope', 'resoucre', function($scope, resoucre) {
    $scope.model = resoucre.data;
  }]);

})(window, document, jQuery, angular);

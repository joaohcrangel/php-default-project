(function(window, document, $, angular) {
  'use strict';

  angular.module('angularapp.angularui.modules', ['ui.sortable', 'ui.select'])
    .controller('SortableDemoController', function($scope) {
      $scope.list = $scope.model.sortable.items;
    }).controller('ConnectedDemoController', function($scope) {
      $scope.leftItems = $scope.model.sortable.left;
      $scope.rightItems = $scope.model.sortable.right;
      $scope.sortableOptions = {
        connectWith: '.connected-sortable .list-group'
      };
    });
})(window, document, jQuery, angular);

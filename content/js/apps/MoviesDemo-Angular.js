var myApp = angular.module('myApp', [
  'ngRoute',
  'MovieControllers'
]);

myApp.config(['$routeProvider', function($routeProvider) {
  $routeProvider.
  when('/list', {
    templateUrl: '/www/content/partials/movies-rating/movies-list.html',
    controller: 'MoviesListController'
  }).
  otherwise({
    redirectTo: '/list'
  });
}]);


angular.module('TwoWayBindingApp', [
	'TwoWayBindingApp.controllers'
])	
var TwoWayBindingControllers = angular.module('TwoWayBindingApp.controllers', []);			

TwoWayBindingControllers.controller('commentsController', function ($scope,$http) {
	var api = "/api/test/index.php";
	$http.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
	$http.get(api+"?action=getComments").success(function(data) {
		$scope.comments = data;
	});	
	$scope.addComment = function(comment) {
		// Validate the comment is not an empty and undefined
		if ("undefined" != comment.msg) {
			// Angular AJAX call
			$http({
				method: "POST",
				url: api,
				data: "action=add&msg=" + comment.msg
			}).success(function(data) {
				// Add the data into DOM for future use
				//$scope.comments.unshift(data);
				$scope.comments = data;
			});
			$scope.comment = "";
		}
	}

	// index : index of global DOM
	$scope.deleteComment = function(index) {
		// Angular AJAX call
		$http({
			method: "GET",
			url: api+"?action=delete&id=" + $scope.comments[index].id,
		}).success(function(data) {
			// Removing Data from Global DOM
			//$scope.comments.splice(index, 1);
			$scope.comments = data;
		});
	}				
})// end controllers

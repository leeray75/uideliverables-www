var MoviesControllers = angular.module('movieApp.controllers', []);

/* Side Menu Controller */
MoviesControllers.controller('asideMenuController', function($scope, $location) {
        $scope.$on('$routeChangeSuccess', function() {
            var array = $location.path().split("/");
            var loc = array[array.length - 1] == "0" ? "add" : array[1];
            $scope.menuActive = loc;
        });
    })
    /* Movies List Controller */
MoviesControllers.controller('MoviesListController', ['$scope', 'dataFactory', 'user', function($scope, dataFactory, user) {
    $scope.pageTitle = "Movies List";
    $scope.statusCount = 0;
    $scope.status = {};
    $scope.movies = null;
    $scope.moviesSearchFilter = function(movie) {
        var re = new RegExp($scope.titleFilter, 'i');
        return !$scope.titleFilter || re.test(movie.title) || re.test(movie.plot);
    };
    $scope.deleteMovie = function(movie) {
            var message = "Delete Movie: " + movie.title + "?";
            $scope.status = {
                type: "CONFIRM",
                message: message,
                title: "Movie Delete Confirmation",
                okCallback: function() {
                        dataFactory.deleteMovie(movie["id"])
                            .success(function(data) {
                                var message = movie.title + " Deleted Successfully!";
                                $scope.status = {
                                    type: "SUCCESS",
                                    message: message,
                                    title: "Movie Deleted",
                                    okCallback: function() {}
                                };

                                $scope.statusCount++;
                                getMovies();
                            }) // end success
                            .error(function(error) {
                                message = error.errorMessage;
                                $scope.status = {
                                    type: "ERROR",
                                    message: message,
                                    title: "ERROR"
                                };

                                $scope.statusCount++;
                            }); // end error
                    } //end okCallback
            }; // end status

            $scope.statusCount++;

        } // end scope.deleteMovie
    function getMovies() {
        dataFactory.getMovies()
            .success(function(data) {
                for (var obj in data) {
                    var movie = data[obj];
                    movie = MovieTemplateHelper.getUpdatedModel(movie,user);
                }
                $scope.movies = data;
            })
            .error(function(error) {
                var message = 'Unable to load movies data: ' + error.errorMessage;
                $scope.status = {
                    type: "ERROR",
                    message: message,
                    title: "ERROR"
                };

                $scope.statusCount++;
            });
    }
    getMovies();

}]);

/* Add/Edit Movies Controller */
MoviesControllers.controller('MoviesAddEditController', ['$scope', '$routeParams', '$route', '$location', 'dataFactory', '$localStorage', '$timeout', 'user', function($scope, $routeParams, $route, $location, dataFactory, $localStorage, $timeout,user) {
    $scope.theForm = null;
    $scope.isDraggable = ('draggable' in document.createElement('span'));
    $scope.id = $routeParams.id;
    $scope.statusCount = 0;
    $scope.status = {};
    $scope.updateLabel = "Update Movie";
    $scope.addLabel = "Add Movie";
    $scope.resetLabel = "Reset Movie";
    $scope.editLabel = "Edit Form";
    $scope.resetData = angular.copy(DefaultMovieModel);
    $scope.movie = angular.copy(DefaultMovieModel);
    $scope.previewMovieItem = null;

    function getLocalCopy() {
        var movie = angular.copy(DefaultMovieModel);
        if ($localStorage["MovieModel"]) {
            movie = angular.fromJson($localStorage["MovieModel"]);
        }
        return angular.fromJson(movie);
    }

    // if the id is zero, the user is adding a new movie
    if ($scope.id == "0") {
        $scope.$watch($scope.movie, function() {
            if ($scope.movie != null) {
                $localStorage["MovieModel"] = $scope.movie;
            }
        });
        $scope.pageTitle = "Create New Movie";
        $scope.movie = getLocalCopy();
        $scope.resetData = angular.copy($scope.movie);
        $scope.previewMovieItem = MovieTemplateHelper.getUpdatedModel(angular.copy($scope.movie));

    } else {
        dataFactory.getMovie($scope.id).success(function(data) {
                $scope.pageTitle = "Update Movie";
                angular.copy(data, $scope.movie);
                $scope.resetData = angular.copy($scope.movie);
                $scope.previewMovieItem = MovieTemplateHelper.getUpdatedModel(angular.copy($scope.movie));
                /* Check if User is a admin and the owner of the movie */
                if (user.isAdmin == false && $scope.movie["user_id"] != user.id) {
                    $location.path('/');
                } 
            })
            .error(function(error) {
                $scope.pageTitle = "Update Movie";
                var message = 'Unable to load movies data: ' + error.errorMessage;
                $scope.status = {
                    type: "ERROR",
                    message: message,
                    title: "ERROR",
                    okCallback: function() {
                        $location.path('/');
                        $scope.$apply();
                    }
                };
                $scope.statusCount++;
            });
    }
    $scope.addMovie = function() {
        if ($scope.theForm.$valid) {

            dataFactory.insertMovie($scope.movie)
                .success(function(data) {
                    var message = "Movie Created Successfully!";
                    $scope.movie["id"] = "0";
                    $scope.status = {
                        type: "SUCCESS",
                        message: message,
                        title: "Add Movie Success",
                        okCallback: function() {
                            $scope.resetMovie();
                        }
                    };
                    $scope.statusCount++;
                })
                .error(function(error) {
                    var message = error.errorMessage;
                    $scope.movie["id"] = "0";
                    $scope.status = {
                        type: "ERROR",
                        message: message,
                        title: "Error Adding Movie"
                    };

                    $scope.statusCount++;
                });
        }
    }
    $scope.setForm = function(form) {
        $scope.theForm = form;
    }

    $scope.updateMovie = function() {
            if ($scope.theForm.$valid) {
                var updatedAttributes = "";
                var updates = 0;
                for (key in $scope.movie) {
                    if ($scope.movie[key] != $scope.resetData[key]) {
                        if (updates > 0) {
                            updatedAttributes += ", ";
                        }
                        updatedAttributes += MovieModelLabels[key];
                        updates++;
                    }
                }
                if (updates > 0) {
                    var movie = angular.copy($scope.movie);
                    for (key in movie) {
                        if (!DefaultMovieModel.hasOwnProperty(key)) {
                            delete movie[key];
                        }
                    }
                    dataFactory.updateMovie(movie)
                        .success(function(data) {
                            angular.copy(data, $scope.movie);
                            var previewMovieItem = MovieTemplateHelper.getUpdatedModel(angular.copy($scope.movie));
                            angular.copy(previewMovieItem, $scope.previewMovieItem);
                            $scope.resetData = angular.copy($scope.movie);
                            var message = "Updated Successfully: " + updatedAttributes;
                            $scope.status = {
                                type: "SUCCESS",
                                message: message,
                                title: "Update Success"
                            };
                            $scope.statusCount++;
                        })
                        .error(function(error) {
                            var message = error.errorMessage;
                            $scope.status = {
                                type: "ERROR",
                                message: error.errorMessage,
                                title: "Update Error"
                            };
                            $scope.statusCount++;
                        });
                } // if updates>0
                else {
                    var message = "Nothing To Update!";
                    $scope.status = {
                        type: "ERROR",
                        message: message,
                        title: "Update Warning"
                    };
                    $scope.statusCount++;
                }
            }
        } // updateMovie

    $scope.resetMovie = function() {
        if ($scope.movie["id"] == "0") {
            // $scope.movie is being watched for local storage. 
            angular.copy(DefaultMovieModel, $scope.movie);
            $timeout(function() {
                $scope.reloadView();
            }, 100);
        } else {
            if ((typeof $scope.theForm != 'undefined') && $scope.theForm != null) {
                $scope.theForm.$setPristine();
                $scope.theForm.$setUntouched();
            }
            angular.copy($scope.resetData, $scope.movie);
        }
    }

    $scope.previewMovie = function() {
        if ((typeof $scope.movie["id"] == 'undefined') || $scope.movie["id"] == "0") {
            //MovieTemplateHelper.setLocalCopy($scope.movie);
        }
        $location.path('/edit/preview/' + $scope.movie["id"]);

    }
    $scope.showMovieForm = function() {
        var movieId = $scope.movie["id"];
        $location.path('/edit/form/' + movieId);

    }
    $scope.reloadView = function() {
        $route.reload();
    }
}]);
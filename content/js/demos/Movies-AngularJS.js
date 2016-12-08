var DefaultMovieModel = {
    "id": "0",
    "user_id": user.id,
    "title": "",
    "plot": "",
    "genre": "",
    "director": "",
    "writers": "",
    "actors": "",
    "poster": "/www/content/images/movie-posters/default.gif",
    "rated": "PG",
    "released": "",
    "year": "",
    "runtime": "",
    "type": "movie",
    "imdbID": "",
    "imdbRating": "0",
    "imdbVotes": "0"
}
var MovieModelLabels = {
    "title": "Title",
    "plot": "Plot",
    "genre": "Genre",
    "director": "Director",
    "writers": "Writers",
    "actors": "Actors",
    "poster": "Poster",
    "rated": "Rated",
    "released": "Release Date",
    "year": "Year",
    "runtime": "Run Time",
    "imdbID": "IMDB ID",
    "imdbRating": "Movie Rating",
    "imdbVotes": "Movie Votes"
}

var MovieTemplateHelper = {
    getUpdatedModel: function(movie, user) {
        var userId = 0;
        var isAdmin = false;
        try {
            userId = user.id;
            isAdmin = user.isAdmin == "1";
        } catch (e) {}
        movie.allowDeleteEdit = ((movie["user_id"] == userId) || isAdmin);
        movie.poster = this.getPosterImageSrc(movie.poster);
        movie.GenreLabel = this.getGenreLabel(movie.genre);
        movie.DisplayReleaseDate = this.getReleaseDateDisplay(movie.released)
        movie.DirectorLabel = this.getDirectorsLabel(movie.director);
        movie.WriterLabel = this.getWritersLabel(movie.writers);
        movie.ActorsLabel = this.getActorsLabel(movie.actors);
        movie.rating = this.getImdbRating(movie.imdbRating, movie.imdbVotes);

        return movie;
    },
    getReleaseDateDisplay: function(Released) {
        var dateArray = Released.split("-");
        var returnVal = "";
        if (dateArray.length == 3) {
            returnVal = dateArray[1] + "-" + dateArray[2] + "-" + dateArray[0];
        }
        return returnVal;
    },
    getGenreLabel: function(Genre) {
        var genresArray = Genre.split(",");
        return genresArray.length > 1 ? "Genres" : "Genre";
    },
    getDirectorsLabel: function(Director) {
        var directorsArray = Director.split(",");
        return directorsArray.length > 1 ? "Directors" : "Director";
    },
    getWritersLabel: function(Writer) {
        var writersArray = Writer.split(",");
        return writersArray.length > 1 ? "Writers" : "Writer";
    },
    getActorsLabel: function(Actors) {
        var actorsArray = Actors.split(",");
        return actorsArray.length > 1 ? "Stars" : "Star";
    },
    getPosterImageSrc: function(Poster) {
        return Poster.replace('http://ia.media-imdb.com/images/', MoviesSettings.PosterImageUri);
    },
    getImdbRating: function(ratings, votes) {
        var rating = ratings / votes;
        var roundedRating = (votes > 0) ? Math.round(rating * 10) / 10 : 0;
        return roundedRating.toFixed(1);
    }
}

var MoviesPlugins = {
        RateItObj: {},
        setNumericField: function(scope, elem, attrs) {
            $(elem).keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: Ctrl+C
                    (e.keyCode == 67 && e.ctrlKey === true) ||
                    // Allow: Ctrl+Z
                    (e.keyCode == 90 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right, down, up
                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        },
        setMaskedYear: function(scope, elem, attrs) {
            $(elem).mask("9999");

        },
        setMaskedDate: function(scope, elem, attrs) {
            $(elem).mask("99-99-9999");
            $(elem).on('blur', function() {
                var released = $(this).val();
                var dateArray = released.split("-");
                if (dateArray[0].length < 4) {
                    released = dateArray[2] + "-" + dateArray[0] + "-" + dateArray[1];
                }
                scope.movie["released"] = released;
            });
        }, // end MoviesPlugins.setMaskedDate
        setReadOnlyRateIt: function(scope, elem, attrs) {
            var imdbRating = 0;
            if ((typeof scope.movie != "undefined") && scope.movie["imdbVotes"] != "0") {
                imdbRating = MovieTemplateHelper.getImdbRating(scope.movie.imdbRating, scope.movie.imdbVotes) / 2;;
            }
            var rateIt;
            var id = attrs["id"];
            var selector = '#' + id;
            if (this.RateItObj.hasOwnProperty(id)) {
                $(selector).find('span.rateit-range').attr('aria-valuenow', imdbRating);
                this.RateItObj[id].rateit("value", imdbRating);
            } else {
                var selector = '#' + id;
                this.RateItObj[id] = $(selector).rateit({
                    "readonly": true,
                    "value": imdbRating,
                    "max": 5
                });
                if (id == "RateIt-User-Preview") {
                    this.RateItObj[id].rateit("value", 0);
                } else {
                    this.RateItObj[id].rateit("value", imdbRating);
                }
            }

        }, //end MoviePlugins.setReadOnlyRateIt
        setUsersRateIt: function(scope, elem, attrs, dataFactory) {
            var previousVal = parseInt(attrs.rating) / 2;
            var rateitObj = $(elem).rateit({
                "beforeSelection": function(prevVal) {
                    previousVal = prevVal;
                },
                "afterSelection": function(val) {
                        var thisObj = this;
                        var movie = angular.copy(scope.movie);
                        var moviesKey = "MovieVotes-" + user.get("id");
                        var votes = (typeof localStorage.getItem(moviesKey) == 'undefined' || localStorage.getItem(moviesKey) == null) ? {} : angular.fromJson(localStorage.getItem(moviesKey));
                        if (!votes.hasOwnProperty("movie_" + movie["id"]) || user.get("isAdmin") == "1") {
                            var movieID = movie['id'];
                            var title = movie['title'];
                            var rating = val * 2;
                            movie['imdbRating'] = (parseInt(movie['imdbRating']) + rating).toString();
                            movie['imdbVotes'] = (parseInt(movie['imdbVotes']) + 1).toString();
                            var vote = {
                                movie_id: 0,
                                ratings: 0,
                                votes: 0
                            }
                            vote["movie_id"] = movie["id"];
                            vote["ratings"] = movie["imdbRating"];
                            vote["votes"] = movie["imdbVotes"];
                            dataFactory.submitVote(vote)
                                .success(function(data) {
                                    dataFactory.getMovie(data["movie_id"]).success(function(data) {
                                        var movie = MovieTemplateHelper.getUpdatedModel(data);
                                        votes["movie_" + movie["id"]] = rating;
                                        localStorage.setItem(moviesKey, angular.toJson(votes));
                                        angular.copy(movie, scope.movie);
                                        thisObj.readonly = true;
                                        var message = "Your vote for \"" + movie["title"] + "\" is successful!";
                                        $(elem).parent().find('.message').remove();
                                        $(elem).parent().prepend('<div class="message" style="color:#f00;">' + message + '</div>');
                                    });


                                })
                                .error(function(error) {
                                    message = 'Unable to submit vote: ' + error.errorMessage;
                                    $(elem).parent().find('.message').remove();
                                    $(elem).parent().prepend('<div class="message" style="color:#f00;">' + message + '</div>');
                                });
                        } else {
                            var message = "You have already voted for this movie!";
                            $(elem).parent().find('.message').remove();
                            $(elem).parent().prepend('<div class="message" style="color:#f00;">' + message + '</div>');
                        }
                    } // end afterSelection
            }); // end rateitObj		
        }, // end MoviesPlugins.setUsersRateIt
        setEditables: function(scope, elem, attrs) {
            var textSettings = {
                cssclass: 'editable-item',
                type: 'text',
                submit: 'OK',
                cancel: 'CANCEL'
            };
            $('.editable-text').editable(function(value, settings) {
                var key = $(this).attr('model-key');
                if ($.trim(value) != "") {
                    scope.movie[key] = value;
                    if (scope.movie["id"] == 0) {
                        //MovieTemplateHelper.setLocalCopy(scope.movie);
                        $('#AddEditForm').submit();
                        scope.theForm[key].$setViewValue(value);
                    } else {
                        scope.updateMovie();
                    }
                    return (value);
                } else {
                    return (scope.movie[key]);
                }
            }, textSettings); // end .editable-text
            var dateSettings = {
                cssclass: 'editable-item',
                type: "masked",
                mask: "99-99-9999",
                submit: 'OK',
                cancel: 'CANCEL'
            };
            $('.editable-date').editable(function(value, settings) {
                var key = $(this).attr('model-key');
                if ($.trim(value) != "") {
                    var released = value;
                    var dateArray = released.split("-");
                    if (dateArray[0].length < 4) {
                        released = dateArray[2] + "-" + dateArray[0] + "-" + dateArray[1];
                    }
                    scope.movie[key] = released;
                    if (scope.movie["id"] == 0) {
                        //MovieTemplateHelper.setLocalCopy(scope.movie);
                        scope.theForm[key].$setViewValue(released);
                    } else {
                        scope.updateMovie();
                    }
                    scope.$apply();
                    return (value);
                } else {
                    return (scope.previewMovieItem["DisplayReleaseDate"]);
                }
            }, dateSettings); // end .editable-date

            var ratingSettings = {
                data: " {'G':'G','PG':'PG','PG-13':'PG-13', 'R':'R'}",
                type: 'select',
                submit: 'OK',
                cancel: 'CANCEL'
            }
            $('#Editable-Select-Rated').editable(function(value, settings) {
                var key = $(this).attr('model-key');
                if ($.trim(value) != "") {
                    scope.movie[key] = value;
                    if (scope.movie["id"] == 0) {
                        //MovieTemplateHelper.setLocalCopy(scope.movie);
                        scope.theForm[key].$setViewValue(value);
                    } else {
                        scope.updateMovie();
                    }
                    return (value);
                } else {
                    return (scope.movie[key]);
                }
            }, ratingSettings); // end .editable-rated	

            var textareaSettings = {
                cssclass: 'editable-item',
                type: 'textarea',
                submit: 'OK',
                cancel: 'CANCEL'
            }
            $('.editable-textarea').editable(function(value, settings) {
                var key = $(this).attr('model-key');
                if ($.trim(value) != "") {
                    scope.movie[key] = value;
                    if (scope.movie["id"] == 0) {
                        //MovieTemplateHelper.setLocalCopy(scope.movie);
                        scope.theForm[key].$setViewValue(value);
                    } else {
                        scope.updateMovie();
                    }
                    return (value);
                } else {
                    return (scope.movie[key]);
                }
            }, textareaSettings); // end .editable						 

        }, // end MoviesPlugins.setEditables
        setDialog: function(scope, elem, attrs) {
            var status = scope.status;
            var okButton = {
                text: "OK",
                click: function() {
                    $(this).dialog("close");
                    try {
                        status.okCallback();
                    } catch (e) {
                        //console.log("OK Callback error: "+e);	
                    }
                }
            };
            var settings = {}
            if (status["type"] == "CONFIRM") {
                settings = {
                        draggable: false,
                        title: status["title"],
                        dialogClass: "confirm-dialog",
                        buttons: [
                            okButton, {
                                text: "CANCEL",
                                click: function() {
                                    $(this).dialog("close");
                                }
                            }
                        ]
                    } // end settings;			
            } else {
                var dClass = status["type"] == "SUCCESS" ? "success-dialog" : "error-dialog";
                settings = {
                        draggable: false,
                        title: status["title"],
                        dialogClass: dClass,
                        buttons: [okButton]
                    } // end settings
            }
            $('#Movies-Dialog').attr("title", status["title"]);
            $('#Movies-Dialog .status-message').html(status["message"]);
            $("#Movies-Dialog").dialog(settings);
            scope.status = angular.copy({});
        }, // end setDialog
        setPosterUpload: function(scope, elem, attrs) {
                var selector = '#' + attrs["id"];
                $(selector).on(
                    'dragover',
                    function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                )
                $(selector).on(
                    'dragenter',
                    function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                )
                $(selector).on('drop', function(event) {
                    event.preventDefault();
                    event.stopPropagation();
                    var files = event.originalEvent.dataTransfer.files;
                    var file = files[0];
                    var fileType = file["type"];
                    var ValidImageTypes = ["image/gif", "image/jpeg", "image/png"];
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                        var status = {
                            type: "ERROR",
                            title: "Upload Error",
                            message: "Invalid Image Type! " + fileType
                        }
                        scope.status = angular.copy(status);
                        MoviesPlugins.setDialog(scope, elem, attrs);
                    } else {
                        var api = '/api/movies/poster-upload.php?mid=' + scope.movie["id"];
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', api, true);
                        xhr.onload = function() {
                            var data = angular.fromJson(xhr.responseText);
                            if (data["status"] == 1) {
                                scope.movie["poster"] = data["image-src"];
                                if (scope.movie["id"] != "0") {
                                    scope.updateMovie();
                                } else {
                                    scope.reloadView();
                                }
                            } else {
                                scope.status = {
                                    type: "ERROR",
                                    title: "Upload Error",
                                    message: "File Upload Error: " + data["message"]

                                }
                                scope.statusCount++;;
                                scope.$apply();
                                //MoviesPlugins.setDialog(scope, elem, attrs);
                            }
                        }; //end xhr.onload	
                        xhr.upload.onprogress = function(event) {
                            if (event.lengthComputable) {
                                var complete = (event.loaded / event.total * 100 | 0);
                            }
                        }; // end xhr.upload.onprogress

                        var formData = new FormData();
                        formData.append('file', file);
                        xhr.send(formData);
                    } // end if else Valid image check
                }); // end $(selector).on('drop'

            } // setPosterUpload
    } //end MoviesPlugins